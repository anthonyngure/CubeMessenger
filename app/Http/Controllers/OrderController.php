<?php
	
	namespace App\Http\Controllers;
	
	use App\Bill;
	use App\CrudHeader;
	use App\Exceptions\WrappedException;
	use App\Notifications\BillCanceledNotification;
	use App\Notifications\OrderNotification;
	use App\Order;
	use App\OrderProduct;
	use App\Product;
	use App\Utils;
	use Auth;
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Http\Request;
	use Validator;
	
	class OrderController extends Controller
	{
		
		/**
		 * Display a listing of the resource.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index(Request $request)
		{
			
			$headers = CrudHeader::whereModel(Order::class)->get();
			
			if (Auth::user()->isAdmin()) {
				$orders = Order::with('items.product')->get();
			} else {
				$client = Auth::user()->getClient();
				$this->validate($request, [
					'filter' => 'required|in:pendingApproval,pendingDelivery,delivered,rejected',
				]);
				
				if ($request->filter === 'pendingApproval') {
					$orders = Order::whereIn('user_id', $client->users->pluck('id'))
						->whereHas('items', function (Builder $builder) {
							$builder->where('status', 'AT_DEPARTMENT_HEAD')
								->orWhere('status', 'AT_PURCHASING_HEAD');
						})
						->with(['items.product', 'user'])
						->get();
				} else if ($request->filter === 'pendingDelivery') {
					$orders = Order::whereIn('user_id', $client->users->pluck('id'))
						->where('status', 'PENDING_DELIVERY')
						->with(['shopProduct', 'user'])
						->get();
				} else if ($request->filter === 'delivered') {
					$orders = Order::whereIn('user_id', $client->users->pluck('id'))
						->where('status', 'DELIVERED')
						->with(['shopProduct', 'user'])
						->get();
				} else {
					$orders = Order::whereIn('user_id', $client->users->pluck('id'))
						->where('status', 'REJECTED')
						->with(['shopProduct', 'user'])
						->with(['rejectedBy' => function (BelongsTo $belongsTo) {
							$belongsTo->with('role');
						}])
						->get();
				}
				
			}
			
			return $this->collectionResponse($orders, ['headers' => $headers]);
			
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 * @throws \Illuminate\Validation\ValidationException
		 */
		public function store(Request $request)
		{
			/** @var \App\User $user */
			$user = Auth::user();
			
			/** @var \App\Client $client */
			$client = $user->getClient();
			
			$orders = $request->json()->all();
			
			if (empty($orders)) {
				throw new WrappedException("Order submitted is in correct!");
			}
			
			$orderProducts = array();
			$total = 0;
			foreach ($orders as $order) {
				Validator::validate($order, [
					'productId' => 'required|numeric|exists:products,id',
					'quantity'  => 'required|numeric',
				]);
				
				/** @var Product $product */
				$product = Product::findOrFail($order['productId']);
				$amount = $product->price * $order['quantity'];
				$total += $amount;
				array_push($orderProducts, new OrderProduct([
					'product_id'        => $order['productId'],
					'quantity'          => $order['quantity'],
					'price_at_purchase' => $product->price,
					'amount'            => $amount,
				]));
			}
			
			
			$insufficientBalanceMessage = 'You have insufficient balance to make an order for '
				. Utils::toCurrencyText($total);
			
			$this->checkBalance($total, $insufficientBalanceMessage);
			
			
			/** @var \App\Order $order */
			$order = $user->orders()->create([]);
			
			/** @var OrderProduct $orderProduct */
			foreach ($orderProducts as $orderProduct) {
				$orderProduct->order_id = $order->id;
				$orderProduct->save();
			}
			
			/** @var \App\Order $order */
			$order = Order::with('items.product')->findOrFail($order->id);
			
			$description = 'Purchase of ' . $order->items->count() . ' products';
			
			Bill::updateOrCreate([
				'client_id'     => $client->id,
				'billable_id'   => $order->id,
				'billable_type' => Order::class,
			], [
				'description' => $description,
				'amount'      => $order->items->sum('amount'),
			]);
			
			$client->notify(new OrderNotification($order));
			
			return $this->itemCreatedResponse($order);
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			//
		}
		
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int                      $id
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 * @throws \Illuminate\Validation\ValidationException
		 * @throws \Exception
		 */
		public function update(Request $request, $id)
		{
			/** @var \App\Order $order */
			$order = Order::with('items.product')->findOrFail($id);
			$client = Auth::user()->getClient();
			
			//Only products can be updated
			$items = $request->json()->all();
			if (count($items) != $order->items->count()) {
				throw new WrappedException("The update can not proceed because the submitted products size are
				not equal to thr existing products size");
			}
			
			foreach ($items as $item) {
				Validator::validate($item, [
					'approved' => 'required|boolean',
				]);
				/** @var \App\OrderProduct $orderProduct */
				$orderProduct = $order->items()->findOrFail($item['id']);
				$this->handleProductApproval($item['approved'], $orderProduct);
			}
			
			$order = Order::with('items.product')->findOrFail($id);
			
			$rejectedCount = $order->items()->where('status', 'REJECTED')->count();
			if ($rejectedCount == $order->items->count()){
				/** @var \App\Bill $bill */
				$bill = $order->bill()->firstOrFail();
				$bill->delete();
				/** @var \App\Client $client */
				$client = $bill->client()->firstOrFail();
				$client->notify(new BillCanceledNotification($bill));
			} else {
				//Update the bill
			}
			
			
			
			return $this->itemUpdatedResponse($order);
			
		}
		
		/**
		 * @param bool $approved
		 * @param      $orderProduct
		 * @throws \App\Exceptions\WrappedException
		 * @throws \Exception
		 */
		private function handleProductApproval(bool $approved, OrderProduct $orderProduct)
		{
			$user = Auth::user();
			if ($approved) {
				$orderProduct->rejected_by_id = $user->getKey();
			}
			
			if (($orderProduct->status == 'AT_DEPARTMENT_HEAD' && $user->isDepartmentHead())) {
				$orderProduct->status = $approved ? 'AT_PURCHASING_HEAD' : 'REJECTED';
				$orderProduct->department_head_acted_at = Carbon::now()->toDateTimeString();
				$orderProduct->save();
			} else if (($orderProduct->status == 'AT_PURCHASING_HEAD' && $user->isPurchasingHead())) {
				$orderProduct->status = $approved ? 'PENDING_DELIVERY' : 'REJECTED';
				$orderProduct->purchasing_head_acted_at = Carbon::now()->toDateTimeString();
				$orderProduct->save();
			} else {
				throw new WrappedException("You are not allowed to perform the requested operation");
			}
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 * @throws \Exception
		 */
		public function destroy($id)
		{
			/** @var Order $order */
			$order = Order::findOrFail($id);
			$order->bill()->delete();
			$order->items()->delete();
			$order->delete();
			
			return $this->itemDeletedResponse($order);
		}
	}

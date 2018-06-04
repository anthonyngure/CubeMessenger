<?php
	
	namespace App\Http\Controllers;
	
	use App\Bill;
	use App\CrudHeader;
	use App\Exceptions\WrappedException;
	use App\Notifications\OrderNotification;
	use App\Order;
	use App\OrderItem;
	use App\Product;
	use App\Utils;
	use Auth;
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
			
			if (Auth::user()->isAdmin() || Auth::user()->isOperations()) {
				$orders = Order::with('items.product')->get();
			} else {
				$client = Auth::user()->getClient();
				$this->validate($request, [
					'filter' => 'required|in:pendingApproval,pendingDelivery,delivered,rejected',
				]);
				
				if ($request->filter === 'pendingApproval') {
					$orders = Order::whereIn('user_id', $client->users->pluck('id'))
						->where('status', 'AT_DEPARTMENT_HEAD')
						->orWhere('status', 'AT_PURCHASING_HEAD')
						->with(['items.product'])
						->get();
				} else if ($request->filter === 'pendingDelivery') {
					$orders = Order::whereIn('user_id', $client->users->pluck('id'))
						->where('status', 'PENDING_DELIVERY')
						->with(['items.product'])
						->get();
				} else if ($request->filter === 'delivered') {
					$orders = Order::whereIn('user_id', $client->users->pluck('id'))
						->where('status', 'DELIVERED')
						->with(['items.product'])
						->get();
				} else {
					$orders = Order::whereIn('user_id', $client->users->pluck('id'))
						->where('status', 'REJECTED')
						->with(['items.product', 'rejectedBy.role'])
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
			
			$submittedOrderItems = $request->json()->all();
			
			if (empty($submittedOrderItems)) {
				throw new WrappedException("Order items cannot be empty!");
			}
			
			$orderItems = array();
			foreach ($submittedOrderItems as $submittedOrderItem) {
				Validator::validate($submittedOrderItem, [
					'productId' => 'required|numeric|exists:products,id',
					'quantity'  => 'required|numeric',
				]);
				
				/** @var Product $product */
				$product = Product::findOrFail($submittedOrderItem['productId']);
				array_push($orderItems, new OrderItem([
					'product_id'        => $submittedOrderItem['productId'],
					'quantity'          => $submittedOrderItem['quantity'],
					'price_at_purchase' => $product->price,
				]));
			}
			
			$totalCost = collect($orderItems)->sum(function (OrderItem $item) {
				return ($item->price_at_purchase * $item->quantity);
			});
			
			$insufficientBalanceMessage = 'You have insufficient balance to make an order for '
				. Utils::toCurrencyText($totalCost);
			
			$this->checkBalance($totalCost, $insufficientBalanceMessage);
			
			
			/** @var \App\Order $order */
			$order = $user->orders()->create([]);
			$order->items()->saveMany($orderItems);
			
			
			/** @var \App\Order $order */
			$order = Order::with('items.product')->findOrFail($order->id);
			
			$description = 'Purchase of ' . $order->items->count() . ' products';
			
			Bill::updateOrCreate([
				'client_id'     => $client->id,
				'billable_id'   => $order->id,
				'billable_type' => Order::class,
			], [
				'description' => $description,
				'amount'      => $order->items->sum(function (OrderItem $item) {
					return ($item->price_at_purchase * $item->quantity);
				}),
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
		 * @throws \Exception
		 */
		public function update(Request $request, $id)
		{
			
			$this->validate($request, [
				'action' => 'required|in:approve,reject',
			]);
			
			
			/** @var \App\Order $order */
			$order = Order::with('items.product')->findOrFail($id);
			
			$this->handleApprovals($request, $order, 'PENDING_DELIVERY', function (Order $order) {
				if ($order->status == 'PENDING_DELIVERY') {
					$order->items()->update(['status' => 'PENDING_LPO']);
				}
			});
			
			//Reload the order after the necessary updates
			$data = Order::with('items.product')->findOrFail($id);
			
			return $this->itemUpdatedResponse($data);
			
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

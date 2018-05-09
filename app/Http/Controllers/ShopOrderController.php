<?php
	
	namespace App\Http\Controllers;
	
	use App\Exceptions\WrappedException;
	use App\ShopOrder;
	use App\ShopProduct;
	use Auth;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Http\Request;
	
	class ShopOrderController extends Controller
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
			$client = Auth::user()->getClient();
			$this->validate($request, [
				'filter' => 'required|in:pendingApproval,pendingDelivery,delivered,rejected',
			]);
			
			if ($request->filter === 'pendingApproval') {
				$orders = ShopOrder::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'AT_DEPARTMENT_HEAD')
					->orWhere('status', 'AT_PURCHASING_HEAD')
					->with(['shopProduct', 'user'])
					->get();
			} else if ($request->filter === 'pendingDelivery') {
				$orders = ShopOrder::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'PENDING_DELIVERY')
					->with(['shopProduct', 'user'])
					->get();
			} else if ($request->filter === 'delivered') {
				$orders = ShopOrder::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'DELIVERED')
					->with(['shopProduct', 'user'])
					->get();
			} else {
				$orders = ShopOrder::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'REJECTED')
					->with(['shopProduct', 'user'])
					->with(['rejectedBy'=>function(BelongsTo $belongsTo){
						$belongsTo->with('role');
					}])
					->get();
			}
			
			return $this->collectionResponse($orders);
			
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function store(Request $request)
		{
			/** @var \App\User $user */
			$user = Auth::user();
			$this->validate($request, [
				'shopProductId' => 'required|numeric|exists:shop_products,id',
				'quantity'      => 'required|numeric',
			]);
			
			$product = ShopProduct::findOrFail($request->shopProductId, ['price']);
			$amount = $product->price * $request->quantity;
			$this->checkBalance($amount);
			
			$shopOrder = ShopOrder::create([
				'user_id'         => $user->getKey(),
				'quantity'        => $request->quantity,
				'shop_product_id' => $request->shopProductId,
			]);
			
			return $this->itemCreatedResponse($shopOrder);
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
		 */
		public function update(Request $request, $id)
		{
			$order = ShopOrder::findOrFail($id);
			$client = Auth::user()->getClient();
			
			$this->validate($request, [
				'action' => 'required|in:approve,reject',
			]);
			
			$this->handleApprovals($request, $order, 'PENDING_DELIVERY');
			
			$orders = ShopOrder::whereIn('user_id', $client->users->pluck('id'))
				->where('status', 'AT_DEPARTMENT_HEAD')
				->orWhere('status', 'AT_PURCHASING_HEAD')
				->with(['shopProduct', 'user'])
				->get();
			
			return $this->collectionResponse($orders);
			
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			//
		}
	}

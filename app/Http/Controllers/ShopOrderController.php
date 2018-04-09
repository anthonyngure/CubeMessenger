<?php
	
	namespace App\Http\Controllers;
	
	use App\Exceptions\WrappedException;
	use App\ShopOrder;
	use Auth;
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
			$client = $this->getClient();
			$this->validate($request, [
				'filter' => 'required|in:count,pendingApproval,pendingDelivery,delivered,rejected',
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
					->with('rejectedBy')
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
			$client = $this->getClient();
			//
			/** @var \App\User $user */
			$user = Auth::user();
			$this->validate($request, [
				'shopProductId' => 'required|numeric|exists:shop_products,id',
				'quantity'      => 'required|numeric',
			]);
			
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
			$client = $this->getClient();
			
			/** @var \App\User $user */
			$user = Auth::user();
			
			$this->validate($request, [
				'action' => 'required|in:approve,reject',
			]);
			
			if ($request->action == 'reject') {
				$order->rejected_by_id = $user->getKey();
			}
			
			if (($order->status == 'AT_DEPARTMENT_HEAD' && $user->isDepartmentHead())) {
				$order->status = $request->action == 'approve' ? 'AT_PURCHASING_HEAD' : 'REJECTED';
				$order->save();
			} else if (($order->status == 'AT_PURCHASING_HEAD' && $user->isPurchasingHead())) {
				$order->status = $request->action == 'approve' ? 'PENDING_DELIVERY' : 'REJECTED';
				$order->save();
			} else {
				throw new WrappedException("You are not allowed to perform the requested operation");
			}
			
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

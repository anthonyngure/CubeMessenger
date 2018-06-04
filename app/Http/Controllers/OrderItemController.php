<?php
	
	namespace App\Http\Controllers;
	
	use App\CrudHeader;
	use App\Notifications\LPONotification;
	use App\OrderItem;
	use App\Product;
	use App\User;
	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Http\Request;
	
	class OrderItemController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function index(Request $request)
		{
			$this->validate($request, [
				'filter' => 'required|in:PENDING_LPO,SENT_LPO,ACCEPTED_LPO,RECEIVED_LPO,REJECTED_LPO',
			]);
			
			$headers = CrudHeader::whereModel(OrderItem::class)->get();
			
			$data = OrderItem::with('product.supplier')
				->where('status', $request->input('filter'))
				->get();
			
			return $this->collectionResponse($data, ['headers' => $headers]);
			
		}
		
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			//
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
		 */
		public function update(Request $request, $id)
		{
			//
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
		
		public function sendLPO()
		{
			$suppliers = User::whereHas('role', function (Builder $builder) {
				return $builder->where('name', 'SUPPLIER');
			})->get();
			
			/** @var \App\User $supplier */
			foreach ($suppliers as $supplier) {
				//Get supplier products
				$products = $supplier->products()->get();
				//dd($products->pluck('id'));
				//Get order items with this supplier products
				$orderItems = OrderItem::whereStatus('PENDING_LPO')->whereIn('product_id', $products->pluck('id'))->get();
				//dd($orderItems->count());
				//Group the orderItems by product id
				$orderItemsGroupedByProductId = $orderItems->groupBy('product_id');
				//dd($orderItemsGroupedByProductId->count());
				$LPOItems = array();
				foreach ($orderItemsGroupedByProductId as $key => $orderItemsProductGroup) {
					
					//dd($orderItemsProductGroup);
					
					//Key is the product Id
					//Sum the total quantity we need for this product from this supplier
					//To make an LPO Item
					/** @var \App\Product $product */
					$product = Product::findOrFail($key);
					array_push($LPOItems, [
						'item'     => $product->name,
						'quantity' => collect($orderItemsProductGroup)->sum('quantity'),
					]);
					
					//Update order items in this product group to status SENT_LPO
					/** @var OrderItem $orderItem */
					foreach ($orderItemsProductGroup as $orderItem) {
						$orderItem->update(['status' => 'SENT_LPO']);
					}
					
				}
				
				if (count($LPOItems) > 0) {
					
					$supplier->notify(new LPONotification($LPOItems, $supplier));
				}
				
			}
			
			
			$data = OrderItem::with('product.supplier')->whereStatus('PENDING_LPO')->get();
			
			return $this->collectionResponse($data);
			
		}
	}

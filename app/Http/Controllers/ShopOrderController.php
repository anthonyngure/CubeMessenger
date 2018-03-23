<?php
	
	namespace App\Http\Controllers;
	
	use App\ShopOrder;
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
				'filter' => 'required|in:count,new,confirmed,delivered',
			]);
			
			if ($request->filter === 'count') {
				$count = $client->shopOrders()->where('status', '!=', 'DELIVERED')
					->count();
				$data = [
					'count' => $count,
				];
				
				return $this->arrayResponse($data);
			} else {
				$orders = $client->shopOrders()->where('status', strtoupper($request->filter))
					->with('shopProduct')
					->get();
				
				return $this->collectionResponse($orders);
			}
			
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
			//
			$client = $this->getClient();
			$this->validate($request, [
				'shopProductId' => 'required|numeric|exists:shop_products,id',
				'quantity'      => 'required|numeric',
			]);
			$shopOrder = $client->shopOrders()->save(new ShopOrder([
				'quantity'        => $request->quantity,
				'shop_product_id' => $request->shopProductId,
			]));
			
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
	}

<?php
	
	namespace App\Http\Controllers;
	
	use App\CrudHeader;
	use App\Product;
	use App\Traits\Paginates;
	use Auth;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Http\Request;
	
	class ProductController extends Controller
	{
		
		use Paginates;
		
		/**
		 * Display a listing of the resource.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index(Request $request)
		{
			$user = Auth::user();
			if ($user->isAdmin()) {
				
				$headers = CrudHeader::whereModel(Product::class)->get();
				
				$products = Product::all();
				
				return $this->collectionResponse($products, ['headers' => $headers]);
				
			} else {
				
				$client = Auth::user()->getClient();
				$this->validate($request, [
					'shopCategoryId' => 'required|exists:shop_categories,id',
				]);
				//
				$products = Product::whereShopCategoryId($request->shopCategoryId)
					->with(['clientOrders' => function (HasMany $hasMany) use ($client) {
						$hasMany->whereIn('user_id', $client->users->pluck('id'))
							->where('status', '!=', 'DELIVERED')
							->where('status', '!=', 'REJECTED');
					}])->get();
				
				return $this->collectionResponse($products);
			}
			
			
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			//
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
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
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

<?php
	
	namespace App\Http\Controllers;
	
	use App\Category;
	use App\CrudHeader;
	use Auth;
	use Illuminate\Http\Request;
	
	class CategoryController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$user = Auth::user();
			
			if ($user->isAdmin() || $user->isOperations()) {
				$headers = CrudHeader::whereModel(Category::class)->get();
				$categories = Category::withCount('products')->get();
				
				//dd($categories->toSql());
				return $this->collectionResponse($categories, ['headers' => $headers]);
			} else {
				
				$categories = Category::with('products')->orderBy('order')->get();
				
				return $this->collectionResponse($categories);
			}
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			$this->validate($request, [
				'name'  => 'required|string|unique,categories',
				'order' => 'required|numeric|min:1|max:20',
			]);
			
			$category = Category::firstOrCreate([
				'name' => $request->input('name'),
			], [
				'order' => $request->input('order'),
			]);
			
			return $this->itemCreatedResponse($category);
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

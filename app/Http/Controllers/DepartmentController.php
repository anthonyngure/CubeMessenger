<?php
	
	namespace App\Http\Controllers;
	
	use App\CrudHeader;
	use App\Department;
	use Auth;
	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;
	
	class DepartmentController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index()
		{
			$headers = CrudHeader::whereModel(Department::class)->get();
			$client = Auth::user()->getClient();
			$departments = $client->departments()->get();
			
			return $this->collectionResponse($departments, ['headers' => $headers]);
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
			$this->validate($request, [
				'name' => 'required|unique:departments',
			]);
			
			$client = Auth::user()->getClient();
			
			$department = $client->departments()->save(new Department([
				'name' => $request->input('name'),
			]));
			
			return $this->itemCreatedResponse($department);
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			$department = Department::findOrFail($id);
			
			return $this->itemResponse($department);
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
			
			$this->validate($request, [
				'name' => ['required', Rule::unique('departments')->ignore($id)],
			]);
			
			$client = Auth::user()->getClient();
			
			$department = $client->departments()->save(new Department([
				'name' => $request->input('name'),
			]));
			
			return $this->itemUpdatedResponse($department);
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

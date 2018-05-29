<?php
	
	namespace App\Http\Controllers;
	
	use App\CrudHeader;
	use App\Role;
	use App\User;
	use Auth;
	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;
	
	class RoleController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$headers = CrudHeader::whereModel(Role::class)->get();
			$roles = Role::all();
			
			return $this->collectionResponse($roles, ['headers' => $headers]);
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
			$this->validate($request, [
				'name'        => 'required|unique:roles',
				'displayName' => 'required|unique:roles,display_name',
			]);
			
			$role = Role::create([
				'name'         => $request->input('name'),
				'display_name' => $request->input('displayName'),
			]);
			
			return $this->itemCreatedResponse($role);
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			$role = Role::findOrFail($id);
			
			return $this->itemResponse($role);
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
			$role = Role::findOrFail($id);
			
			$this->validate($request, [
				'name'        => ['required', Rule::unique('roles')->ignore($id)],
				'displayName' => ['required', Rule::unique('roles', 'display_name')->ignore($id)],
			]);
			
			$role->update([
				'name'         => $request->input('name'),
				'display_name' => $request->input('displayName'),
			]);
			
			return $this->itemUpdatedResponse($role);
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
		
		/**
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function search(Request $request)
		{
			
			
			$this->validate($request, [
				'search' => 'required',
			]);
			$query = $request->search . '';
			
			
			/** @var \App\User $user */
			$user = User::with('role')->findOrFail(Auth::user()->getKey());
			
			if ($user->isAdmin()) {
				$suggestions = Role::where('name', 'LIKE', '%' . $query . '%')
					->where('display_name', 'LIKE', '%' . $query . '%')
					->get(['id', 'name']);
			} else {
				
				$suggestions = Role::where('name', 'LIKE', '%' . $query . '%')
					->where('display_name', 'LIKE', '%' . $query . '%')
					->where(function (Builder $query) use ($user) {
						$query->where('name', '!=', 'ADMIN');
					})->get(['id', 'name']);
				
			}
			
			
			return $this->collectionResponse($suggestions);
		}
	}

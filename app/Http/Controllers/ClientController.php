<?php
	
	namespace App\Http\Controllers;
	
	use App\Client;
	use App\CrudHeader;
	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;
	
	class ClientController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$headers = CrudHeader::whereModel(Client::class)->get();
			$clients = Client::all();
			
			return $this->collectionResponse($clients, ['headers' => $headers]);
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
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			
			$this->validate($request, [
				'name'        => 'required',
				'email'       => 'required|email|unique:users,email',
				'phone'       => 'required:digits:10|unique:users,phone',
				'accountType' => 'required|in:POST_PAID,PRE_PAID',
				'limit'       => 'required|numeric',
			]);
			
			$client = Client::create([
				'name'         => $request->input('name'),
				'email'        => $request->input('email'),
				'phone'        => $request->input('phone'),
				'account_type' => $request->input('accountType'),
				'limit'        => $request->input('limit'),
			]);
			
			return $this->itemCreatedResponse($client);
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
			
			$client = Client::findOrFail($id);
			
			$this->validate($request, [
				'name'        => 'required',
				'email'       => ['required', 'email', Rule::unique('users')->ignore($id)],
				'phone'       => ['required:digits:10', Rule::unique('users')->ignore($id)],
				'accountType' => 'required|in:POST_PAID,PRE_PAID',
				'limit'       => 'required|numeric',
			]);
			
			$client->update([
				'name'         => $request->input('name'),
				'email'        => $request->input('email'),
				'phone'        => $request->input('phone'),
				'account_type' => $request->input('accountType'),
				'limit'        => $request->input('limit'),
			]);
			
			return $this->itemUpdatedResponse($client);
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
			
			$suggestions = Client::where('name', 'LIKE', '%' . $query . '%')
				->where('email', 'LIKE', '%' . $query . '%')
				->get(['id','name']);
			
			return $this->collectionResponse($suggestions);
		}
	}

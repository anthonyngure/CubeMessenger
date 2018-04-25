<?php
	
	namespace App\Http\Controllers;
	
	use App\Traits\Messages;
	use App\User;
	use App\Utils;
	use Illuminate\Http\Request;
	use TCG\Voyager\Models\Role;
	
	class UserController extends Controller
	{
		use Messages;
		
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index()
		{
			$client = $this->getClient();
			$users = $client->users()->get();
			
			return $this->collectionResponse($users);
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
			$data = [
				'phone' => Utils::normalizePhone($request->phone),
			];
			
			\Validator::validate($data, [
				'phone' => 'required|unique:users',
			]);
			//
			$this->validate($request, [
				'name'         => 'required',
				'password'     => 'required',
				'role'         => 'required|in:CLIENT_ADMIN,PURCHASING_HEAD,DEPARTMENT_HEAD,DEPARTMENT_USER',
				'email'        => 'required|unique:users',
				'departmentId' => 'required_if:role,DEPARTMENT_USER|required_if:role,DEPARTMENT_HEAD',
			]);
			
			
			$client = $this->getClient();
			
			
			/** @var User $user */
			$user = $client->users()->save(new User([
				'department_id' => $request->departmentId,
				'name'          => $request->name,
				'email'         => $request->email,
				'phone'         => Utils::normalizePhone($request->phone),
				'role_id'       => Role::where('name', $request->role)->firstOrFail()->getKey(),
				'password'      => bcrypt($request->password),
			]));
			
			$smsText = 'Hi ' . $user->name . ', your Cube Messenger password is ' . $request->password;
			
			$this->sendSMS($smsText, $user->phone);
			
			//Mail::to($user)->send(new Password($user, $password));
			
			return $this->itemCreatedResponse($user);
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

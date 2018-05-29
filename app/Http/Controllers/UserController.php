<?php
	
	namespace App\Http\Controllers;
	
	use App\Appointment;
	use App\CrudHeader;
	use App\Exceptions\WrappedException;
	use App\Notifications\PasswordChanged;
	use App\Role;
	use App\Traits\Messages;
	use App\User;
	use Auth;
	use Hash;
	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Http\Request;
	use Illuminate\Validation\Rule;
	
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
			$headers = CrudHeader::whereModel(User::class)->get();
			/** @var User $user */
			$user = Auth::user();
			if ($user->isAdmin()) {
				$users = User::with('role', 'client')->get();
			} else {
				$client = $user->getClient();
				$users = $client->users()->get();
			}
			
			return $this->collectionResponse($users, ['headers' => $headers]);
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
			
			if (Auth::user()->isAdmin()) {
				
				$this->validate($request, [
					'name'         => 'required',
					'password'     => 'required',
					'roleId'       => 'required|exists:roles,id',
					'clientId'     => 'required|exists:clients,id',
					'email'        => 'required|unique:users',
					'phone'        => 'required|unique:users',
					'departmentId' => 'nullable|exists:departments,id',
				]);
				
				
				/** @var User $user */
				$user = User::create([
					'name'      => $request->input('name'),
					'email'     => $request->input('email'),
					'phone'     => $request->input('phone'),
					'role_id'   => $request->input('roleId'),
					'client_id' => $request->input('clientId'),
					'password'  => Hash::make($request->input('password')),
				]);
				
			} else {
				
				$client = Auth::user()->getClient();
				
				$this->validate($request, [
					'name'           => 'required',
					'password'       => 'required',
					'role'           => 'required|in:CLIENT_ADMIN,PURCHASING_HEAD,DEPARTMENT_HEAD,DEPARTMENT_USER',
					'departmentId' => 'required_if:role,DEPARTMENT_HEAD|required_if:role,DEPARTMENT_USER|exists:departments,id',
					'email'          => 'required|unique:users',
					'phone'          => 'required|unique:users',
				]);
				
				/** @var User $user */
				$user = $client->users()->save(new User([
					'department_id' => $request->input('departmentId'),
					'name'          => $request->input('name'),
					'email'         => $request->input('email'),
					'phone'         => $request->input('phone'),
					'role_id'       => Role::whereName($request->input('role'))->firstOrFail(['id'])->id,
					'password'      => Hash::make($request->input('password')),
				]));
			}
			
			$smsText = 'Hi ' . $user->name . ', your Cube Messenger password is ' . $request->input('password');
			
			$this->sendSMS($smsText, $user->phone);
			
			return $this->show($user->id);
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			$user = User::with(User::loadableRelations())->findOrFail($id);
			
			return $this->itemResponse($user);
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
			
			$user = User::findOrFail($id);
			
			if (Auth::user()->isAdmin()) {
				
				$this->validate($request, [
					'name'         => 'required',
					'password'     => 'required',
					'roleId'       => 'required|exists:roles,id',
					'clientId'     => 'required|exists:clients,id',
					'email'        => ['required', Rule::unique('users')->ignore($id)],
					'phone'        => ['required', Rule::unique('users')->ignore($id)],
					'departmentId' => 'nullable|exists:departments,id',
				]);
				
				
				/** @var User $user */
				$user->update([
					'name'      => $request->input('name'),
					'email'     => $request->input('email'),
					'phone'     => $request->input('phone'),
					'role_id'   => $request->input('roleId'),
					'client_id' => $request->input('clientId'),
					'password'  => Hash::make($request->input('password')),
				]);
				
			} else {
				
				$client = Auth::user()->getClient();
				
				$this->validate($request, [
					'name'         => 'required',
					'role'         => 'required|in:CLIENT_ADMIN,PURCHASING_HEAD,DEPARTMENT_HEAD,DEPARTMENT_USER',
					'departmentId' => 'required_if:role,DEPARTMENT_HEAD|required_if:role,DEPARTMENT_USER|exists:departments,id',
					'email'        => ['required', Rule::unique('users')->ignore($id)],
					'phone'        => ['required', Rule::unique('users')->ignore($id)],
				]);
				
				/** @var User $user */
				$user->update([
					'department_id' => $request->input('departmentId'),
					'name'          => $request->input('name'),
					'email'         => $request->input('email'),
					'phone'         => $request->input('phone'),
					'role_id'       => Role::whereName($request->input('role'))->firstOrFail(['id'])->id,
				]);
			}
			
			
			if (!empty($request->input('password'))) {
				
				$user->password = Hash::make($request->input('password'));
				$user->save();
				
				$smsText = 'Hi ' . $user->name . ', your Cube Messenger password is ' . $request->input('password');
				
				$this->sendSMS($smsText, $user->phone);
				
			}
			
			
			return $this->show($user->id);
			
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 * @throws \Exception
		 */
		public function destroy($id)
		{
			$user = User::findOrFail($id);
			$user->delete();
			
			return $this->itemDeletedResponse($user);
		}
		
		/**
		 * @throws \App\Exceptions\WrappedException
		 */
		public function appointments()
		{
			$client = Auth::user()->getClient();
			$appointments = Appointment::whereIn('user_id', $client->users->pluck('id'))
				->whereHas('internalParticipants', function (Builder $builder) {
					$builder->where('user_id', Auth::user()->getKey());
				})
				->whereDate('starting_at', '>=', now()->toDateString())
				->with('items')
				->orderBy('starting_at')
				->get();
			
			return $this->collectionResponse($appointments);
		}
		
		/**
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function changePassword(Request $request)
		{
			$this->validate($request, [
				'currentPassword' => 'required',
				'newPassword'     => 'required',
				'confirmPassword' => 'required',
			]);
			
			/** @var User $user */
			$user = Auth::user();
			
			if (!Hash::check($request->currentPassword, $user->password)) {
				throw new WrappedException("You entered a wrong current password");
			}
			
			if ($request->newPassword != $request->confirmPassword) {
				throw new WrappedException("Your new password and password confirmation don't match!");
			}
			
			$user->password = Hash::make($request->newPassword);
			$user->save();
			
			$user->notify(new PasswordChanged());
			
			return $this->arrayResponse([]);
		}
	}

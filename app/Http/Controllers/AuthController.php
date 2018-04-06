<?php
	/**
	 * Created by PhpStorm.
	 * User: Tosh
	 * Date: 17/01/2017
	 * Time: 20:10
	 */
	
	namespace App\Http\Controllers;
	
	
	use App\Exceptions\WrappedException;
	use App\User;
	use App\Utils;
	use Auth;
	use Hash;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Http\Request;
	use JWTAuth;
	
	class AuthController extends Controller
	{
		
		/**
		 * @param \App\User  $user
		 * @param array|null $meta
		 * @return \Illuminate\Http\Response
		 */
		private function authenticateUser(User $user, array $meta = null)
		{
			$user = User::with(['client' => function (BelongsTo $belongsTo) {
				$belongsTo->with(['users', 'departments']);
			}])->findOrFail($user->getKey());
			$token = JWTAuth::fromUser($user);
			
			$user->token = $token;
			
			return $this->itemResponse($user, null, $meta == null ? array() : $meta)
				->header('Authorization', $token);
		}
		
		
		/**
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws WrappedException
		 */
		public function signIn(Request $request)
		{
			$this->validate($request, [
				'signInId' => 'required',
				'password' => 'required',
			]);
			
			$user = User::where('phone', Utils::normalizePhone($request->signInId))
				->orWhere('email', $request->signInId)->first();
			
			if ($user == null) {
				$errorMessage = $request->signInId . ' is not a registered email address or phone number. '
					. 'Please use your correct Sign In details or create an account.';
				throw new WrappedException($errorMessage);
			}
			
			if (!Hash::check($request->password, $user->password)) {
				throw new WrappedException("You entered a wrong password");
			}
			
			return $this->authenticateUser($user, ['message' => 'Signed In successfully.']);
		}
		
		
		public function user()
		{
			$user = User::with(['client' => function (BelongsTo $belongsTo) {
				$belongsTo->with(['users', 'departments']);
			}])->findOrFail(Auth::user()->getKey());
			
			return $this->itemResponse($user);
		}
		
		public function refresh()
		{
			$user = User::with(['client' => function (BelongsTo $belongsTo) {
				$belongsTo->with(['users', 'departments']);
			}])->findOrFail(Auth::user()->getKey());
			
			return $this->itemResponse($user);
		}
		
		public function signOut()
		{
			Auth::logout();
			
			return $this->arrayResponse([]);
		}
	}
<?php
	
	namespace App\Http\Middleware;
	
	use App\Exceptions\WrappedException;
	use App\User;
	use Auth;
	use Closure;
	
	class CheckAdmin
	{
		/**
		 * Handle an incoming request.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \Closure                 $next
		 * @return mixed
		 * @throws \App\Exceptions\WrappedException
		 */
		public function handle($request, Closure $next)
		{
			/** @var \App\User $user */
			$user = User::with('role')->findOrFail(Auth::user()->id);
			if ($user->isAdmin()) {
				return $next($request);
			} else {
				throw new WrappedException("You are not authorized to access this resource");
			}
		}
	}

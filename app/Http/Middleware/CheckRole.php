<?php

namespace App\Http\Middleware;

use App\Exceptions\WrappedException;
use App\User;
use Auth;
use Closure;

class CheckRole
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 * @param array                     $roles
	 * @return mixed
	 * @throws \App\Exceptions\WrappedException
	 */
    public function handle($request, Closure $next, ...$roles)
    {
	    //$roles = array_except(func_get_args(), [0,1]);
    	//dd($roles);
	    /** @var \App\User $user */
	    $user = User::with('role')->findOrFail(Auth::user()->id);
	    
	    if (in_array($user->role->name, $roles)) {
		    return $next($request);
	    } else {
		    throw new WrappedException("You are not authorized to access this resource");
	    }
    }
}

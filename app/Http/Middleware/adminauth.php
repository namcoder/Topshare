<?php namespace App\Http\Middleware;

use Closure;
use Auth;
class adminauth {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(Auth::check()){
			if (Auth::user()->role!=1)
			{
				return redirect('/');
			}
			else{
				return $next($request);
			}
		}
		else{
			return redirect('admin-login');
		}
	}

}

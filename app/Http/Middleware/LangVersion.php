<?php namespace App\Http\Middleware;

use Closure;

class LangVersion {

	
	public function handle($request, Closure $next)
	{
		
		$lang = \Session::get ('locale');

		if($lang){
			\App::setLocale($lang);
			return $next($request);
		}
		return $next($request);
		
	}

}

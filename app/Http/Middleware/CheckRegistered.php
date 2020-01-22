<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redirect;
use Closure;

class CheckRegistered
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!session()->has('auth')) {
			return redirect('/')->with('valiMsg', 'アカウントにログインしてください。');
		}
		return $next($request);
	}
}

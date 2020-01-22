<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redirect;
use Closure;

class CheckMasterAuth
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
		if (session()->get('auth') !== 0) {
			return redirect('/')->with('valiMsg', 'マスターアカウントにログインしてください。');
		}
		return $next($request);
	}
}

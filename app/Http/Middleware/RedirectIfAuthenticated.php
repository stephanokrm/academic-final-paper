<?php namespace Academic\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticated {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (Session::has('user'))
		{
			return new RedirectResponse(route('home.index'));
		}

		return $next($request);
	}

}

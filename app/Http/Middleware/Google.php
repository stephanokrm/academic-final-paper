<?php

namespace Academic\Http\Middleware;

use Closure;
use Redirect;
use Session;

class Google {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Session::has('credentials')) {
            return $next($request);
        }

        return Redirect::route('home.index')->withMessage('Conta Google necessária.');
    }

}

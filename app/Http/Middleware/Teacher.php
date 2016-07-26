<?php

namespace Academic\Http\Middleware;

use Closure;
use Redirect;
use Session;

class Teacher {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Session::get('user')->hasRole(2)) {
            return $next($request);
        }

        return Redirect::back()->withMessage('Perfil de Professor necessário.');
    }

}

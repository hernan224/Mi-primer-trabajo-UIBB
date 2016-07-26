<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($request->user()->hasRole('escuela')) {
                return redirect()->route('escuela.admin_alumnos');
            }
            elseif ($request->user()->hasRole('admin')) {
                return redirect()->route('publicaciones.admin_publicaciones');
            }
        }

        return $next($request);
    }
}

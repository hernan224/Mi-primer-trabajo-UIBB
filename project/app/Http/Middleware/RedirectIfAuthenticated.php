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
            if ($request->user()->hasRole('institucion')) {
                return redirect()->route('institucion.admin_egresados');
            }
            elseif ($request->user()->hasRole('admin')) {
                return redirect()->route('publicaciones.admin_publicaciones');
            }
        }

        return $next($request);
    }
}

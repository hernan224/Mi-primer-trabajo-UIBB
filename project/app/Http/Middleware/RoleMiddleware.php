<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Chequea si el usuario tiene determinado rol
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @return mixed
     */
    public function handle($request, Closure $next,$role = null)
    {
        // Si no tiene el rol indicado, no permite el request
        if (!$request->user()->hasRole($role) ) {
            return abort(403);
        }

        return $next($request);
    }
}

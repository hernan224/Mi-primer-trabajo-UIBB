<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Chequea si el usuario tiene determinado rol (o es admin)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next,$role = null)
    {
        // Si no es admin y no tiene el rol indicado, no permite el request
        if (!$request->user()->hasRole('admin') &&
                !$request->user()->hasRole($role) ) {
            return response('No autorizado', 403);
        }

        return $next($request);
    }
}

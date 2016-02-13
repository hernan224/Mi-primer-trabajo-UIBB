<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('edit-alumno', function ($user, $alumno) {
            if (!$user->puedeEditar())
                return false;
            if ($user->hasRole('admin'))
                return true;
            // si no, es docente, verifico que el alumno sea de su escuela
            return $user->escuela->id == $alumno->escuela_id;
        });

        $gate->define('show-alumno', function ($user, $alumno) {
            if ($user->hasRole('admin') || $user->hasRole('empresa'))
                return true;
            // si no, es docente, verifico que el alumno sea de su escuela
            return $user->escuela->id == $alumno->escuela_id;
        });
    }
}

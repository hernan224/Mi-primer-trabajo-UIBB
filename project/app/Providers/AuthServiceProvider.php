<?php

namespace App\Providers;

use App\Models\User;
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
            /** @var User $user */
            if (!$user->puedeEditar())
                return false;
            // si no, es docente, verifico que el alumno sea de su escuela
            return $user->escuela->id == $alumno->escuela_id;
        });

        $gate->define('show-alumno-privado', function ($user, $alumno) {
            // chequeo que sea de la escuela del usuario
            /** @var User $user */
            return $user->hasRole('escuela') && $user->escuela->id == $alumno->escuela_id;
        });
    }
}

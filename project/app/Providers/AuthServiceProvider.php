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

        $gate->define('edit-egresado', function ($user, $egresado) {
            /** @var User $user */
            if (!$user->puedeEditar())
                return false;
            // si no, es docente, verifico que el egresado sea de su institucion
            return $user->institucion->id == $egresado->institucion_id;
        });

        $gate->define('show-egresado-privado', function ($user, $egresado) {
            // chequeo que sea de la institucion del usuario
            /** @var User $user */
            return $user->hasRole('institucion') && $user->institucion->id == $egresado->institucion_id;
        });
    }
}

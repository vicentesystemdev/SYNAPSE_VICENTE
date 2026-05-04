<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Definir Gates para los roles
        Gate::define('manage-admin-dashboard', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-admins', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-students', function (User $user) {
            return $user->hasRole('admin') || $user->hasRole('docente');
        });

        Gate::define('manage-docentes', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-docente-dashboard', function (User $user) {
            return $user->hasRole('docente');
        });
    }
}

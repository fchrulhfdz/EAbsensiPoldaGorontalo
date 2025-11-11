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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define gates for role-based authorization
        Gate::define('is-super-admin', function (User $user) {
            return $user->role === 'super_admin';
        });

        Gate::define('is-admin', function (User $user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        Gate::define('is-user', function (User $user) {
            return $user->role === 'user';
        });

        Gate::define('access-admin-panel', function (User $user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        Gate::define('manage-users', function (User $user) {
            return $user->role === 'super_admin';
        });

        Gate::define('view-reports', function (User $user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        // Gate untuk fitur spesifik
        Gate::define('generate-reports', function (User $user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        Gate::define('manage-attendances', function (User $user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });
    }
}
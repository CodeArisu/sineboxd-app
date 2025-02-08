<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {   
        // defines the admin gate
        Gate::define('admin', function ($user) {
            return $user->role->role === 'admin';
        });

        // to be added special cases for different roles
    }
}

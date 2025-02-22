<?php

namespace App\Providers;

use App\Services\AuthService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Registered;

class AuthLogsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {   
        // registers the AuthService class as a singleton
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $authService = app(AuthService::class);

        Event::listen(Login::class, [$authService, 'logLogin']);
        Event::listen(Logout::class, [$authService, 'logLogout']);
        Event::listen(Failed::class, [$authService, 'logFailedLogin']);
        Event::listen(Registered::class, [$authService, 'logRegistration']);
    }
}

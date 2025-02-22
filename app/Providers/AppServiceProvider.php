<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void    
    {
        set_exception_handler(function ($e) { // catch global unexpected exceptions
            Log::error('Unhandled Exception: '.$e->getMessage());
        });
    }
}

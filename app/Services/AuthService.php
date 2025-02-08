<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Registered;

class AuthService
{
    public function logLogin(Login $event) 
    {
        Log::info('User Logged in: ', ['email' => $event->user->email, 'Time' => now()]);
    }
    public function logLogout(Logout $event) 
    {
        Log::info('User Logged Out: ', ['email' => $event->user->email, 'Time' => now()]);
    }
    public function logFailedLogin(Failed $event) 
    {
        Log::warning('Failed Login Attempt: ', ['email' => $event->credentials['email'] ?? 'unknown', 'Time' => now()]);
    }
    public function logRegistration(Registered $event) 
    {
        Log::info('User Registered: ', ['email' => $event->user->email, 'Time' => now()]);
    }
}

<?php
// app/Listeners/LogUserLogin.php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\SessionAnalytic;
use App\Models\UserActivity;

class LogUserLogin
{
    public function handle(Login $event)
    {
        // Create session analytic
        SessionAnalytic::create([
            'user_id' => $event->user->id,
            'login_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // Log activity
        UserActivity::create([
            'user_id' => $event->user->id,
            'action' => 'login',
            'description' => 'User logged in',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}
<?php
// app/Listeners/LogUserLogout.php
namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\SessionAnalytic;
use App\Models\UserActivity;

class LogUserLogout
{
    public function handle(Logout $event)
    {
        if ($event->user) {
            // Update session analytic
            $lastSession = SessionAnalytic::where('user_id', $event->user->id)
                ->whereNull('logout_at')
                ->latest('login_at')
                ->first();

            if ($lastSession) {
                $lastSession->update([
                    'logout_at' => now(),
                    'duration_seconds' => now()->diffInSeconds($lastSession->login_at)
                ]);
            }

            // Log activity
            UserActivity::create([
                'user_id' => $event->user->id,
                'action' => 'logout',
                'description' => 'User logged out',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
        }
    }
}
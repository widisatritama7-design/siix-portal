<?php

namespace App\Jobs;

use App\Models\ESD\Locker\Locker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AutoCloseLockerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lockerId;

    public function __construct($lockerId)
    {
        $this->lockerId = $lockerId;
    }

    public function handle()
    {
        $locker = Locker::find($this->lockerId);
        
        if (!$locker) {
            return;
        }

        Log::info('AutoCloseLockerJob running', [
            'code' => $locker->code,
            'status' => $locker->status,
            'is_open' => $locker->is_open
        ]);

        // SETELAH 15 DETIK: RESET KE AVAILABLE
        $locker->update([
            'is_open' => false,
            'opened_at' => null,
            'locked_until' => null,
            'status' => 'available',
            'employee_id' => null
        ]);

        Log::info('AutoCloseLockerJob completed - locker now AVAILABLE', [
            'code' => $locker->code
        ]);
    }
}
<?php

namespace App\Console\Commands\ESD;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetFinishedLocker extends Command
{
    protected $signature = 'locker:reset-finished';

    protected $description = 'Reset locker finished tanpa employee menjadi available';

    public function handle()
    {
        $updated = DB::table('tb_esd_locker')
            ->where('status', 'finished')
            ->where(function ($query) {
                $query->whereNull('employee_id')
                    ->orWhere('employee_id', '');
            })
            ->update([
                'status' => 'available',
                'is_open' => 0,
                'updated_at' => now(),
            ]);

        if ($updated > 0) {
            $this->info("{$updated} locker berhasil di-reset.");
        }

        return Command::SUCCESS;
    }
}
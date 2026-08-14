<?php

namespace Database\Seeders;

use App\Models\ESD\Locker\Locker;
use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\Employee;
use Illuminate\Database\Seeder;

class ESDTestSeeder extends Seeder
{
    public function run()
    {
        // Buat 16 loker jika belum ada
        if (Locker::count() == 0) {
            for ($i = 1; $i <= 16; $i++) {
                Locker::create([
                    'code' => 'ESD' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'status' => 'available'
                ]);
            }
            $this->command->info('16 lockers created!');
        }

        // Buat transaksi test
        $employee = Employee::first();
        if ($employee) {
            $locker = Locker::available()->first();
            if ($locker) {
                // Buat transaksi dengan cara yang benar
                $transaction = UniformTransaction::create([
                    'employee_id' => $employee->id,
                    'locker_id' => $locker->id,
                    'type' => 'store',
                    'status' => 'pending',
                    'access_code' => strtoupper(substr(md5(uniqid() . $employee->id . now()), 0, 10)), // Generate langsung
                    'expires_at' => now()->addHours(24)
                ]);
                
                $this->command->info('Test transaction created!');
                $this->command->info('Access Code: ' . $transaction->access_code);
                $this->command->info('Locker: ' . $locker->code);
                $this->command->info('Employee: ' . $employee->name);
            } else {
                $this->command->error('No available lockers found!');
            }
        } else {
            $this->command->error('No employee found! Please add employee data first.');
        }
    }
}
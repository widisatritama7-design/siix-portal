<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Convert to VARCHAR temporarily
        DB::statement("ALTER TABLE tb_esd_locker MODIFY status VARCHAR(20)");
        
        // Step 2: Update existing data
        DB::table('tb_esd_locker')
            ->where('status', 'open')
            ->update(['status' => 'available']);
            
        DB::table('tb_esd_locker')
            ->where('status', 'on_progress')
            ->update(['status' => 'in_progress']);
        
        // Step 3: Change back to ENUM with new values
        DB::statement("ALTER TABLE tb_esd_locker MODIFY status ENUM('available', 'open', 'in_progress', 'ng', 'finished') DEFAULT 'available'");
    }

    public function down(): void
    {
        // Step 1: Convert to VARCHAR temporarily
        DB::statement("ALTER TABLE tb_esd_locker MODIFY status VARCHAR(20)");
        
        // Step 2: Rollback data
        DB::table('tb_esd_locker')
            ->where('status', 'available')
            ->update(['status' => 'open']);
            
        DB::table('tb_esd_locker')
            ->where('status', 'in_progress')
            ->update(['status' => 'on_progress']);
        
        // Step 3: Change back to ENUM with old values
        DB::statement("ALTER TABLE tb_esd_locker MODIFY status ENUM('open', 'on_progress', 'ng', 'finished') DEFAULT 'open'");
    }
};
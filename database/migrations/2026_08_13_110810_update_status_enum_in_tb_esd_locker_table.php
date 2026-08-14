<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, drop the existing enum constraint
        DB::statement("ALTER TABLE tb_esd_locker MODIFY status VARCHAR(20)");
        
        // Then update the values
        DB::statement("UPDATE tb_esd_locker SET status = 'open' WHERE status = 'available'");
        DB::statement("UPDATE tb_esd_locker SET status = 'on_progress' WHERE status = 'occupied'");
        DB::statement("UPDATE tb_esd_locker SET status = 'finished' WHERE status = 'maintenance'");
        
        // Finally, change back to enum with new values
        DB::statement("ALTER TABLE tb_esd_locker MODIFY status ENUM('open', 'on_progress', 'ng', 'finished') DEFAULT 'open'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, drop the existing enum constraint
        DB::statement("ALTER TABLE tb_esd_locker MODIFY status VARCHAR(20)");
        
        // Then update the values back
        DB::statement("UPDATE tb_esd_locker SET status = 'available' WHERE status = 'open'");
        DB::statement("UPDATE tb_esd_locker SET status = 'occupied' WHERE status = 'on_progress'");
        DB::statement("UPDATE tb_esd_locker SET status = 'maintenance' WHERE status = 'finished'");
        DB::statement("UPDATE tb_esd_locker SET status = 'maintenance' WHERE status = 'ng'");
        
        // Finally, change back to enum with old values
        DB::statement("ALTER TABLE tb_esd_locker MODIFY status ENUM('available', 'occupied', 'maintenance') DEFAULT 'available'");
    }
};
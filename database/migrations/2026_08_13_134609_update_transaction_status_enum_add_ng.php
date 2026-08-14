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
        // Step 1: Convert to VARCHAR temporarily
        DB::statement("ALTER TABLE tb_esd_uniform_transactions MODIFY status VARCHAR(50)");
        
        // Step 2: Update existing data jika ada yang perlu diubah
        // Tidak perlu update data, hanya tambah enum
        
        // Step 3: Change back to ENUM with new values including 'ng'
        DB::statement("ALTER TABLE tb_esd_uniform_transactions MODIFY status ENUM('pending', 'on_progress', 'waiting_pickup', 'completed', 'ng') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Convert to VARCHAR temporarily
        DB::statement("ALTER TABLE tb_esd_uniform_transactions MODIFY status VARCHAR(50)");
        
        // Step 2: Update data yang status 'ng' menjadi 'pending' atau lainnya
        DB::statement("UPDATE tb_esd_uniform_transactions SET status = 'pending' WHERE status = 'ng'");
        
        // Step 3: Change back to ENUM with old values
        DB::statement("ALTER TABLE tb_esd_uniform_transactions MODIFY status ENUM('pending', 'on_progress', 'waiting_pickup', 'completed') DEFAULT 'pending'");
    }
};
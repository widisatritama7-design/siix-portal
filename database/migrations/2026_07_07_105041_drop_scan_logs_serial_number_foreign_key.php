<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_prod_scan_logs', function (Blueprint $table) {
            // Hapus foreign key constraint yang mengacu ke pcbs.serial_number
            $table->dropForeign('scan_logs_serial_number_foreign');
        });
    }

    public function down(): void
    {
        Schema::table('tb_prod_scan_logs', function (Blueprint $table) {
            // Kembalikan foreign key jika rollback
            $table->foreign('serial_number')
                  ->references('serial_number')
                  ->on('pcbs')
                  ->onDelete('cascade');
        });
    }
};
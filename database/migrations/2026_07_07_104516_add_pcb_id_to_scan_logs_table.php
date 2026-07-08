<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_prod_scan_logs', function (Blueprint $table) {
            // Tambah kolom pcb_id
            if (!Schema::hasColumn('tb_prod_scan_logs', 'pcb_id')) {
                $table->unsignedBigInteger('pcb_id')->nullable()->after('serial_number');
                $table->foreign('pcb_id')
                      ->references('id')
                      ->on('tb_prod_pcbs')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tb_prod_scan_logs', function (Blueprint $table) {
            $table->dropForeign(['pcb_id']);
            $table->dropColumn('pcb_id');
        });
    }
};
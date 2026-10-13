<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_scan_xray', function (Blueprint $table) {
            // Pilihan tunggal: SINGLE / LH / RH
            $table->string('pcb_type', 20)->nullable()->after('model_id');
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_scan_xray', function (Blueprint $table) {
            $table->dropColumn('pcb_type');
        });
    }
};
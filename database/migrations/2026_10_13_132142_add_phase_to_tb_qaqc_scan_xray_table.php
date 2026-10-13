<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_scan_xray', function (Blueprint $table) {
            // first | middle | last | completed
            $table->string('phase', 20)->default('first')->after('pcb_type');
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_scan_xray', function (Blueprint $table) {
            $table->dropColumn('phase');
        });
    }
};
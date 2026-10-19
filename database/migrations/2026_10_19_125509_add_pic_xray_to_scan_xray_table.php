<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_scan_xray', function (Blueprint $table) {
            $table->string('pic_xray')->nullable()->after('lot_qty');
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_scan_xray', function (Blueprint $table) {
            $table->dropColumn('pic_xray');
        });
    }
};
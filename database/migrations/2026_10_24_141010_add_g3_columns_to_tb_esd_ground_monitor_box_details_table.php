<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_ground_monitor_box_details', function (Blueprint $table) {
            $table->boolean('g_3_1')->nullable()->after('g_4');
            $table->boolean('g_3_2')->nullable()->after('g_3_1');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_ground_monitor_box_details', function (Blueprint $table) {
            $table->dropColumn(['g_3_1', 'g_3_2']);
        });
    }
};
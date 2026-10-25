<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_equipment_ground_details', function (Blueprint $table) {
            $table->boolean('eg_3_1')->nullable()->after('judgement_volts');
            $table->boolean('eg_3_2')->nullable()->after('eg_3_1');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_equipment_ground_details', function (Blueprint $table) {
            $table->dropColumn(['eg_3_1', 'eg_3_2']);
        });
    }
};
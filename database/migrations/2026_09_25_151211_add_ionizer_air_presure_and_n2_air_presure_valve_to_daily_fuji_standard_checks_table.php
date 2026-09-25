<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_mtc_daily_fuji_standard_checks', function (Blueprint $table) {
            $table->boolean('ionizer_air_presure_required')
                ->default(false)
                ->after('ionizer_required');

            $table->boolean('n2_air_presure_valve_required')
                ->default(false)
                ->after('temperature_control_3_required');
        });
    }

    public function down(): void
    {
        Schema::table('tb_mtc_daily_fuji_standard_checks', function (Blueprint $table) {
            $table->dropColumn([
                'ionizer_air_presure_required',
                'n2_air_presure_valve_required',
            ]);
        });
    }
};
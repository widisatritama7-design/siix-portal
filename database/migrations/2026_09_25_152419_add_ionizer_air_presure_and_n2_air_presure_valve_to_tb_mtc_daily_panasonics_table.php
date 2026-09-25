<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_mtc_daily_panasonics', function (Blueprint $table) {
            $table->string('ionizer_air_presure')
                ->nullable()
                ->after('ionizer');

            $table->string('n2_air_presure_valve')
                ->nullable()
                ->after('temperature_control_3');
        });
    }

    public function down(): void
    {
        Schema::table('tb_mtc_daily_panasonics', function (Blueprint $table) {
            $table->dropColumn([
                'ionizer_air_presure',
                'n2_air_presure_valve',
            ]);
        });
    }
};
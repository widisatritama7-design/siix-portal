<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_soldering_details', function (Blueprint $table) {
            $table->boolean('e2_1')->nullable()->after('judgement');
            $table->boolean('e2_2')->nullable()->after('e2_1');
            $table->boolean('e2_3')->nullable()->after('e2_2');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_soldering_details', function (Blueprint $table) {
            $table->dropColumn(['e2_1', 'e2_2', 'e2_3']);
        });
    }
};
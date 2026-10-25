<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_insulatif_checks', function (Blueprint $table) {
            $table->boolean('c_3_1')->nullable()->after('judgement');
            $table->boolean('c_3_2')->nullable()->after('c_3_1');
            $table->boolean('c_3_3')->nullable()->after('c_3_2');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_insulatif_checks', function (Blueprint $table) {
            $table->dropColumn(['c_3_1', 'c_3_2', 'c_3_3']);
        });
    }
};
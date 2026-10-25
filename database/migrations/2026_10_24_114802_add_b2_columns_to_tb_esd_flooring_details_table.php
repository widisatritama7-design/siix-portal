<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_flooring_details', function (Blueprint $table) {
            $table->boolean('b2_1')->nullable()->after('judgement');
            $table->boolean('b2_2')->nullable()->after('b2_1');
            $table->boolean('b2_3')->nullable()->after('b2_2');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_flooring_details', function (Blueprint $table) {
            $table->dropColumn(['b2_1', 'b2_2', 'b2_3']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_ionizer_details', function (Blueprint $table) {
            $table->boolean('c4_1')->nullable()->after('judgement_c3');
            $table->boolean('c4_2')->nullable()->after('c4_1');
            $table->boolean('c4_3')->nullable()->after('c4_2');
            $table->boolean('c4_4')->nullable()->after('c4_3');
            $table->boolean('c4_5')->nullable()->after('c4_4');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_ionizer_details', function (Blueprint $table) {
            $table->dropColumn(['c4_1', 'c4_2', 'c4_3', 'c4_4', 'c4_5']);
        });
    }
};
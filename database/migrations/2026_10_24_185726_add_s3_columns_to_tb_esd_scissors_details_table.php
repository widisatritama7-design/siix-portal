<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_scissors_details', function (Blueprint $table) {
            $table->boolean('s_3_1')->nullable()->after('judgement_s_2');
            $table->boolean('s_3_2')->nullable()->after('s_3_1');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_scissors_details', function (Blueprint $table) {
            $table->dropColumn(['s_3_1', 's_3_2']);
        });
    }
};
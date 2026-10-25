<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_glove_details', function (Blueprint $table) {
            $table->boolean('c_2_1')->nullable()->after('judgement');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_glove_details', function (Blueprint $table) {
            $table->dropColumn(['c_2_1']);
        });
    }
};
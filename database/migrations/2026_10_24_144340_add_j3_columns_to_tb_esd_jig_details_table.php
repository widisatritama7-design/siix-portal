<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_jig_details', function (Blueprint $table) {
            // Default true karena tidak ada input di form, asumsi lolos inspeksi visual
            $table->boolean('j_3_1')->default(true)->after('judgement_j2');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_jig_details', function (Blueprint $table) {
            $table->dropColumn(['j_3_1']);
        });
    }
};
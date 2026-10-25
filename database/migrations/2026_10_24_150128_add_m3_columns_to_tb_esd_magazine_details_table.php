<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_magazine_details', function (Blueprint $table) {
            $table->boolean('m_3_1')->nullable()->after('judgement_m2');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_magazine_details', function (Blueprint $table) {
            $table->dropColumn(['m_3_1']);
        });
    }
};
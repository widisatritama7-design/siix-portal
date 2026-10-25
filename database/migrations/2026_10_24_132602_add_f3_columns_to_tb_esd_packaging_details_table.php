<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_packaging_details', function (Blueprint $table) {
            $table->boolean('f3_1')->nullable()->after('judgement_f2');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_packaging_details', function (Blueprint $table) {
            $table->dropColumn(['f3_1']);
        });
    }
};
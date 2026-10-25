<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_garment_details', function (Blueprint $table) {
            $table->decimal('d5', 20, 2)->nullable()->after('judgement_d4');
            $table->string('d5_scientific', 30)->nullable()->after('d5');
            $table->string('judgement_d5', 10)->nullable()->after('d5_scientific');
            $table->boolean('d6_1')->nullable()->after('judgement_d5');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_garment_details', function (Blueprint $table) {
            $table->dropColumn(['d5', 'd5_scientific', 'judgement_d5', 'd6_1']);
        });
    }
};
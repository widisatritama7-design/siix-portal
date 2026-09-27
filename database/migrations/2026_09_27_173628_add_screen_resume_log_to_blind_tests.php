<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->json('screen_resume_log')->nullable()->after('screen_stopped_at');
            $table->integer('screen_resume_count')->default(0)->after('screen_resume_log');
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->dropColumn(['screen_resume_log', 'screen_resume_count']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            // Cek dulu kolomnya, kalau belum ada baru ditambah
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'user_answers')) {
                $table->json('user_answers')->nullable()->after('blind_test_items');
            }
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'started_at')) {
                $table->timestamp('started_at')->nullable()->after('time_actual');
            }
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'finished_at')) {
                $table->timestamp('finished_at')->nullable()->after('started_at');
            }
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'duration_seconds')) {
                $table->integer('duration_seconds')->nullable()->after('finished_at');
            }
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'status')) {
                $table->enum('status', ['pending', 'in_progress', 'completed'])
                    ->default('pending')->after('duration_seconds');
            }
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'overall_result')) {
                $table->enum('overall_result', ['PASS', 'FAIL'])
                    ->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->dropColumn([
                'user_answers', 'started_at', 'finished_at',
                'duration_seconds', 'status', 'overall_result',
            ]);
        });
    }
};
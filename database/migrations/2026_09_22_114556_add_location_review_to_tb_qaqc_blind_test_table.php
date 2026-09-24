<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            // Flag kalau sudah selesai direview QC
            $table->boolean('is_reviewed')->default(false)->after('overall_result');
            $table->timestamp('reviewed_at')->nullable()->after('is_reviewed');
            $table->foreignId('reviewed_by')->nullable()->after('reviewed_at')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn(['is_reviewed', 'reviewed_at', 'reviewed_by']);
        });
    }
};
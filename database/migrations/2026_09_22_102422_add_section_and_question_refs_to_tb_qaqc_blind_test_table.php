<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            // Section (QC, SMT, BE, MI)
            $table->string('section')->nullable()->after('group');

            // Question reference (bank soal yang dipilih)
            $table->foreignId('question_id')->nullable()->after('section')
                ->constrained('tb_qaqc_question')->nullOnDelete();

            // Snapshot soal (untuk trace kalau question diubah/dihapus)
            $table->json('question_snapshot')->nullable()->after('blind_test_items');

            // Auto-save marker
            $table->boolean('auto_saved')->default(false)->after('status');
            $table->timestamp('auto_saved_at')->nullable()->after('auto_saved');
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->dropColumn([
                'section', 'question_id',
                'question_snapshot', 'auto_saved', 'auto_saved_at',
            ]);
        });
    }
};
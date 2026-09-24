<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->integer('attempt')->default(1)->after('status');
            $table->integer('max_attempt')->default(2)->after('attempt');

            // Data percobaan pertama (untuk history)
            $table->json('first_attempt_answers')->nullable()->after('user_answers');
            $table->string('first_attempt_result')->nullable()->after('first_attempt_answers');
            $table->timestamp('first_attempt_at')->nullable()->after('first_attempt_result');

            // ID untuk retry (self-reference)
            $table->unsignedBigInteger('retry_from_id')->nullable()->after('first_attempt_at');
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->dropColumn([
                'attempt', 'max_attempt',
                'first_attempt_answers', 'first_attempt_result', 'first_attempt_at',
                'retry_from_id',
            ]);
        });
    }
};
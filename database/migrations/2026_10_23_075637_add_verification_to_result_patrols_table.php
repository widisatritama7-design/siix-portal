<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_prod_result_patrol', function (Blueprint $table) {
            // Menyimpan history revisi (action + evidence_action lama per finding)
            $table->json('action_history')->nullable()->after('finding_patrol_items');

            // Menyimpan log verifikasi (approve / reject per finding)
            $table->json('verification_log')->nullable()->after('action_history');

            // Siapa & kapan yang memverifikasi terakhir
            $table->unsignedBigInteger('verified_by')->nullable()->after('verification_log');
            $table->timestamp('verified_at')->nullable()->after('verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_prod_result_patrol', function (Blueprint $table) {
            $table->dropColumn([
                'action_history',
                'verification_log',
                'verified_by',
                'verified_at',
            ]);
        });
    }
};
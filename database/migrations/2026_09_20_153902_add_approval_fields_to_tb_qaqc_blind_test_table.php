<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'check_by_qc_at')) {
                $table->timestamp('check_by_qc_at')->nullable()->after('check_by_qc');
            }
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'check_by_prod_at')) {
                $table->timestamp('check_by_prod_at')->nullable()->after('check_by_prod');
            }
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'acknowledge_by_spv_at')) {
                $table->timestamp('acknowledge_by_spv_at')->nullable()->after('acknowledge_by_spv');
            }
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'acknowledge_qc_spv_at')) {
                $table->timestamp('acknowledge_qc_spv_at')->nullable()->after('acknowledge_qc_spv');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->dropColumn([
                'check_by_qc_at', 'check_by_prod_at',
                'acknowledge_by_spv_at', 'acknowledge_qc_spv_at',
            ]);
        });
    }
};
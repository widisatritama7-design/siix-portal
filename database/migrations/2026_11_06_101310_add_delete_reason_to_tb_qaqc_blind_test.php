<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            // Kolom kode alasan (salah_submit, waktu_habis, dll)
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'deleted_reason_code')) {
                $table->string('deleted_reason_code', 50)
                    ->nullable()
                    ->after('deleted_by')
                    ->comment('Kode alasan hapus');
            }

            // Kolom teks alasan (bisa berisi label default atau keterangan tambahan)
            if (!Schema::hasColumn('tb_qaqc_blind_test', 'deleted_reason')) {
                $table->string('deleted_reason', 500)
                    ->nullable()
                    ->after('deleted_reason_code')
                    ->comment('Alasan/keterangan hapus');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->dropColumn(['deleted_reason_code', 'deleted_reason']);
        });
    }
};
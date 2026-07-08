<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_prod_ng_boxes', function (Blueprint $table) {
            // Tambah kolom pcb_id
            if (!Schema::hasColumn('tb_prod_ng_boxes', 'pcb_id')) {
                $table->unsignedBigInteger('pcb_id')->nullable()->after('serial_number');
                $table->foreign('pcb_id')
                      ->references('id')
                      ->on('tb_prod_pcbs')
                      ->onDelete('cascade');
            }
            
            // Tambah kolom locked_at jika belum ada
            if (!Schema::hasColumn('tb_prod_ng_boxes', 'locked_at')) {
                $table->timestamp('locked_at')->nullable()->after('unlock_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tb_prod_ng_boxes', function (Blueprint $table) {
            $table->dropForeign(['pcb_id']);
            $table->dropColumn('pcb_id');
            $table->dropColumn('locked_at');
        });
    }
};
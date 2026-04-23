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
        Schema::table('tb_qaqc_ncp', function (Blueprint $table) {
            // Tambahkan soft delete column
            $table->softDeletes(); // menambahkan kolom deleted_at
            
            // Tambahkan kolom untuk mencatat siapa yang menghapus
            $table->unsignedBigInteger('deleted_by')->nullable()->after('updated_by');
            
            // Tambahkan kolom untuk alasan penghapusan
            $table->text('deleted_reason')->nullable()->after('deleted_by');
            
            // Optional: Tambahkan foreign key constraint jika diperlukan
            // $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_qaqc_ncp', function (Blueprint $table) {
            // Hapus foreign key jika ada
            // $table->dropForeign(['deleted_by']);
            
            // Drop kolom yang ditambahkan
            $table->dropSoftDeletes();
            $table->dropColumn(['deleted_by', 'deleted_reason']);
        });
    }
};
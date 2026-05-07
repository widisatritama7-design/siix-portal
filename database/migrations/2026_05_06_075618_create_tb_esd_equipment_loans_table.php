<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_esd_equipment_loans', function (Blueprint $table) {
            $table->id();
            
            // Data peminjam
            $table->string('employee_id', 50)->comment('NIK atau ID Karyawan');
            $table->date('loan_date')->comment('Tanggal Pinjam');
            $table->date('return_date')->nullable()->comment('Tanggal Kembali');
            
            // Pilihan alat: Wrist Strap, Sepatu Putih, Sepatu Safety
            $table->enum('equipment_loan', [
                'wrist_strap', 
                'sepatu_putih', 
                'sepatu_safety'
            ])->comment('Jenis Alat: Wrist Strap, Sepatu Putih, Sepatu Safety');
            
            // Status: borrowed, returned, confirmed, approved
            $table->enum('status', [
                'borrowed',   // Dipinjam
                'returned',   // Dikembalikan
                'confirmed',  // Dikonfirmasi
                'approved'    // Disetujui
            ])->default('borrowed')->comment('Status Peminjaman');
            
            // Audit fields
            $table->string('created_by', 100)->nullable()->comment('Dibuat oleh');
            $table->string('updated_by', 100)->nullable()->comment('Diupdate oleh');
            $table->string('confirm_by', 100)->nullable()->comment('Dikonfirmasi oleh');
            $table->string('approve_by', 100)->nullable()->comment('Disetujui oleh');
            
            $table->timestamps();
            
            // Index untuk performance
            $table->index('employee_id');
            $table->index('loan_date');
            $table->index('status');
            $table->index('equipment_loan');
            $table->index(['status', 'loan_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_esd_equipment_loans');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_qaqc_scan_xray_edit_requests', function (Blueprint $table) {
            $table->id();

            // Scan yang diminta untuk diedit
            $table->foreignId('scan_xray_id')
                ->constrained('tb_qaqc_scan_xray')
                ->cascadeOnDelete();

            // Group yang diminta: ['first_piece_items', 'middle_piece_items', ...]
            $table->json('requested_groups');

            // Alasan request
            $table->text('reason')->nullable();

            // Status: pending → approved / rejected, approved → revoked (dicabut)
            $table->enum('status', ['pending', 'approved', 'rejected', 'revoked'])
                ->default('pending');

            // Siapa yang request
            $table->foreignId('requested_by')
                ->constrained('users')
                ->restrictOnDelete();

            // Siapa yang approve/reject
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('reject_reason')->nullable();

            // Approval otomatis expire (opsional, misal 24 jam)
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();

            // Index untuk performa query
            $table->index('scan_xray_id');
            $table->index('status');
            $table->index(['scan_xray_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_qaqc_scan_xray_edit_requests');
    }
};
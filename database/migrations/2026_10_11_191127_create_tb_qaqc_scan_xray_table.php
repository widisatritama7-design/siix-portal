<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_qaqc_scan_xray', function (Blueprint $table) {
            $table->id();

            // Header
            $table->foreignId('customer_id')->constrained('tb_qaqc_customer')->cascadeOnDelete();
            $table->foreignId('model_id')->constrained('tb_qaqc_model')->cascadeOnDelete();
            $table->string('shift');
            $table->string('group');
            $table->foreignId('master_line_id')->constrained('tb_mtc_master_lines')->cascadeOnDelete();
            $table->integer('lot_qty')->default(0);

            // Detail (JSON)
            $table->json('first_piece_items')->nullable();
            $table->json('middle_piece_items')->nullable();
            $table->json('last_piece_items')->nullable();

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'model_id']);
            $table->index('master_line_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_qaqc_scan_xray');
    }
};
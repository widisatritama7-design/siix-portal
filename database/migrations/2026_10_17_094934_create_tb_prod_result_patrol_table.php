<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_prod_result_patrol', function (Blueprint $table) {
            $table->id();
            $table->string('shift'); // NS, 1, 2, 3
            $table->string('group'); // A, B, C
            $table->unsignedBigInteger('master_line_id'); // Relasi ke tb_mtc_master_lines
            
            // Array JSON untuk item standard (item_check, standard, result, remarks)
            $table->json('standard_patrol_items')->nullable();
            
            // Array JSON untuk finding (category_id, finding_result, evidence, feedback_to, reason, action, evidence_action)
            $table->json('finding_patrol_items')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('master_line_id')->references('id')->on('tb_mtc_master_lines')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_prod_result_patrol');
    }
};
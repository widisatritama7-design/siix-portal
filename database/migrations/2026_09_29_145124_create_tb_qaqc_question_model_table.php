<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_qaqc_question_model', function (Blueprint $table) {
            $table->id();

            $table->foreignId('question_id')
                  ->constrained('tb_qaqc_question')
                  ->cascadeOnDelete();

            $table->foreignId('model_id')
                  ->constrained('tb_qaqc_model')
                  ->cascadeOnDelete();

            $table->timestamps();

            // Cegah duplikat: 1 question tidak boleh punya model yang sama 2x
            $table->unique(['question_id', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_qaqc_question_model');
    }
};
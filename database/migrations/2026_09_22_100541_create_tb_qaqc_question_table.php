<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_qaqc_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('tb_qaqc_customer')->cascadeOnDelete();
            $table->foreignId('model_id')->constrained('tb_qaqc_model')->cascadeOnDelete();
            $table->string('section'); // QC, SMT, BE, MI
            $table->json('items'); // [{deffect_id, deffect_name, location}]
            $table->text('question_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_qaqc_question');
    }
};
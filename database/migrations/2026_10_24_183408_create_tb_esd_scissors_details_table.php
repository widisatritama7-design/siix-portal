<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_esd_scissors_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scissors_id')->constrained('tb_esd_scissors')->cascadeOnDelete();
            
            // S-1 (Resistance)
            $table->decimal('s_1', 20, 2)->nullable();
            $table->string('s_1_scientific', 30)->nullable();
            $table->string('judgement_s_1', 10)->nullable();

            // S-2 (Voltage)
            $table->decimal('s_2', 10, 2)->nullable();
            $table->string('judgement_s_2', 10)->nullable();

            $table->text('remarks')->nullable();
            $table->date('next_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_esd_scissors_details');
    }
};
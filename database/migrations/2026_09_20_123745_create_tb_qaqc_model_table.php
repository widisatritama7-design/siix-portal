<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_qaqc_model', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('model_name');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index('model_name');
            $table->foreign('customer_id')->references('id')->on('tb_qaqc_customer')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_qaqc_model');
    }
};
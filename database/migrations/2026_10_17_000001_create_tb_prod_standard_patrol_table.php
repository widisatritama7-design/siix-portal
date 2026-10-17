<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_prod_standard_patrol', function (Blueprint $table) {
            $table->id();
            $table->string('line')->nullable();
            $table->string('item_check')->nullable();
            $table->text('standard')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->index('line');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_prod_standard_patrol');
    }
};
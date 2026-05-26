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
        Schema::create('tb_prod_master_uniform', function (Blueprint $table) {
            $table->id();
            $table->string('item_code', 100)->unique();
            $table->string('description', 255);
            $table->string('size', 50);
            
            // Track who created and updated the record
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            
            $table->timestamps();
            
            // Optional: add index for faster searching
            $table->index('item_code');
            $table->index('size');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_prod_master_uniform');
    }
};
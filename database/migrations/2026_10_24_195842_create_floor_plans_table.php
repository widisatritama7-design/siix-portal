<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah bagian ini
        Schema::create('tb_floor_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->integer('grid_width')->default(1000); 
            $table->integer('grid_height')->default(800); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Ubah juga di down()
        Schema::dropIfExists('tb_floor_plans');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah bagian ini
        Schema::create('tb_floor_items', function (Blueprint $table) {
            $table->id();
            
            // Pastikan constrained-nya menunjuk ke tb_floor_plans
            $table->foreignId('floor_plan_id')->constrained('tb_floor_plans')->cascadeOnDelete();
            
            $table->string('type'); 
            $table->string('label'); 
            $table->float('x')->default(0);
            $table->float('y')->default(0);
            $table->float('width')->default(100);
            $table->float('height')->default(100);
            $table->json('config')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Ubah juga di down()
        Schema::dropIfExists('tb_floor_items');
    }
};
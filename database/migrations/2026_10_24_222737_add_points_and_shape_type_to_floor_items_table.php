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
        Schema::table('tb_floor_items', function (Blueprint $table) {
            $table->string('shape_type')->default('box'); // 'box' atau 'polygon'
            $table->json('points')->nullable(); // Menyimpan array koordinat [{x:10, y:10}, ...]
        });
    }

    public function down(): void
    {
        Schema::table('tb_floor_items', function (Blueprint $table) {
            $table->dropColumn(['shape_type', 'points']);
        });
    }
};

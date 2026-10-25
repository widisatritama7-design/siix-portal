<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_floor_items', function (Blueprint $table) {
            // Menambahkan parent_id (nullable karena root/floor plan tidak punya parent)
            $table->foreignId('parent_id')->nullable()->constrained('tb_floor_items')->cascadeOnDelete();
            // Menambahkan kolom level untuk mempermudah query (1=Area, 2=Location, dst)
            $table->integer('level')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('tb_floor_items', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'level']);
        });
    }
};
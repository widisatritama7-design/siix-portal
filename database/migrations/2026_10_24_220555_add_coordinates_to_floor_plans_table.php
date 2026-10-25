<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_floor_plans', function (Blueprint $table) {
            $table->float('x')->default(40);
            $table->float('y')->default(40);
            $table->float('width')->default(200);
            $table->float('height')->default(150);
            $table->string('color')->default('#0f172a');
        });
    }

    public function down(): void
    {
        Schema::table('tb_floor_plans', function (Blueprint $table) {
            $table->dropColumn(['x', 'y', 'width', 'height', 'color']);
        });
    }
};
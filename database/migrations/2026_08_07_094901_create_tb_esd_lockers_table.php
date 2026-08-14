<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_esd_locker', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->timestamp('locked_until')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_esd_locker');
    }
};
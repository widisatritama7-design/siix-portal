<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_esd_uniform_recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('nik')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable(); // email manual input
            $table->string('department')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('employee_id');
            $table->index('nik');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('esd_uniform_recipients');
    }
};
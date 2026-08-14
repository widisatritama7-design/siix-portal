<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_esd_uniform_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('locker_id');
            $table->enum('type', ['store', 'take']);
            $table->enum('status', ['pending', 'on_progress', 'completed', 'waiting_pickup'])->default('pending');
            $table->string('access_code', 50)->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('stored_at')->nullable();
            $table->timestamp('taken_at')->nullable();
            $table->timestamps();

            $table->foreign('locker_id')->references('id')->on('tb_esd_lockers')->onDelete('cascade');
            
            $table->index(['employee_id', 'status']);
            $table->index('access_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_esd_uniform_transactions');
    }
};
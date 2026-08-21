<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('esp_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->unique();
            $table->string('name')->nullable();
            $table->enum('status', ['connected', 'disconnected'])->default('disconnected');
            $table->string('ip_address')->nullable();
            $table->integer('rssi')->nullable();
            $table->integer('uptime_seconds')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->json('locker_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('esp_devices');
    }
};
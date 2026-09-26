<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            // Status verifikasi browser & kamera
            $table->boolean('browser_verified')->default(false)->after('is_reviewed');
            $table->boolean('camera_enabled')->default(false)->after('browser_verified');

            // Info browser (user agent, screen, dll) → JSON string
            $table->text('browser_info')->nullable()->after('camera_enabled');

            // Hasil rekaman kamera
            $table->string('camera_recording_path')->nullable()->after('browser_info');
            $table->unsignedBigInteger('camera_recording_size')->nullable()->after('camera_recording_path');
            $table->timestamp('camera_started_at')->nullable()->after('camera_recording_size');
            $table->timestamp('camera_stopped_at')->nullable()->after('camera_started_at');
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->dropColumn([
                'browser_verified',
                'camera_enabled',
                'browser_info',
                'camera_recording_path',
                'camera_recording_size',
                'camera_started_at',
                'camera_stopped_at',
            ]);
        });
    }
};
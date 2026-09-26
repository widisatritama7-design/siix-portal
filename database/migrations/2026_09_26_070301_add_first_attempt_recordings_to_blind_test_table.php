<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            // Rekaman attempt pertama (disimpan saat retry)
            $table->string('first_attempt_camera_path')->nullable()->after('camera_stopped_at');
            $table->unsignedBigInteger('first_attempt_camera_size')->nullable()->after('first_attempt_camera_path');

            $table->string('first_attempt_screen_path')->nullable()->after('first_attempt_camera_size');
            $table->unsignedBigInteger('first_attempt_screen_size')->nullable()->after('first_attempt_screen_path');
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->dropColumn([
                'first_attempt_camera_path',
                'first_attempt_camera_size',
                'first_attempt_screen_path',
                'first_attempt_screen_size',
            ]);
        });
    }
};
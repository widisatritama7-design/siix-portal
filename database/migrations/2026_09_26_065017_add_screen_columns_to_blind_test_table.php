<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->string('screen_recording_path')->nullable()->after('camera_stopped_at');
            $table->unsignedBigInteger('screen_recording_size')->nullable()->after('screen_recording_path');
            $table->boolean('screen_enabled')->default(false)->after('screen_recording_size');
            $table->timestamp('screen_started_at')->nullable()->after('screen_enabled');
            $table->timestamp('screen_stopped_at')->nullable()->after('screen_started_at');
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->dropColumn([
                'screen_recording_path',
                'screen_recording_size',
                'screen_enabled',
                'screen_started_at',
                'screen_stopped_at',
            ]);
        });
    }
};
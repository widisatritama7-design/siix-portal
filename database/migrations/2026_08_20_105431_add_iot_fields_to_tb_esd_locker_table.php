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
        Schema::table('tb_esd_locker', function (Blueprint $table) {
            // Status fisik loker (terbuka/tertutup)
            $table->boolean('is_open')->default(false)->after('status');
            
            // Waktu terakhir loker dibuka
            $table->timestamp('opened_at')->nullable()->after('is_open');
            
            // Status koneksi ESP32 (online/offline)
            $table->boolean('is_online')->default(false)->after('opened_at');
            
            // IP Address ESP32
            $table->string('ip_address')->nullable()->after('is_online');
            
            // Port ESP32 (default 80)
            $table->integer('port')->default(80)->after('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_esd_locker', function (Blueprint $table) {
            $table->dropColumn([
                'is_open',
                'opened_at',
                'is_online',
                'ip_address',
                'port'
            ]);
        });
    }
};
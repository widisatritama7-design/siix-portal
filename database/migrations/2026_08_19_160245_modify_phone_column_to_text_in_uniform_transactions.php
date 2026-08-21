<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_uniform_transactions', function (Blueprint $table) {
            // Ubah dari VARCHAR(20) menjadi TEXT untuk menampung hasil enkripsi
            $table->text('phone')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_uniform_transactions', function (Blueprint $table) {
            // Kembalikan ke VARCHAR(20) jika rollback (hati-hati dengan data)
            $table->string('phone', 20)->nullable()->change();
        });
    }
};
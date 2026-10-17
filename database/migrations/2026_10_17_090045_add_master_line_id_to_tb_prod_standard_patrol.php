<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_prod_standard_patrol', function (Blueprint $table) {
            // Simpan array ID master line sebagai JSON
            $table->json('master_line_id')->nullable()->after('line');
        });
    }

    public function down(): void
    {
        Schema::table('tb_prod_standard_patrol', function (Blueprint $table) {
            $table->dropColumn('master_line_id');
        });
    }
};
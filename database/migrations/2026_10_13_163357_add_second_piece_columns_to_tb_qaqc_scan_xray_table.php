<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_qaqc_scan_xray', function (Blueprint $table) {
            $table->json('second_first_items')->nullable()->after('first_piece_items');
            $table->json('second_middle_items')->nullable()->after('middle_piece_items');
            $table->json('second_last_items')->nullable()->after('last_piece_items');
        });
    }

    public function down(): void
    {
        Schema::table('tb_qaqc_scan_xray', function (Blueprint $table) {
            $table->dropColumn(['second_first_items', 'second_middle_items', 'second_last_items']);
        });
    }
};
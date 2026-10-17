<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_prod_result_patrol', function (Blueprint $table) {
            $table->string('status')->default('Open')->after('master_line_id');
        });
    }

    public function down(): void
    {
        Schema::table('tb_prod_result_patrol', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
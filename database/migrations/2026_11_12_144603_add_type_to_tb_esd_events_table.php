<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_events', function (Blueprint $table) {
            $table->string('type')->default('Project')->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_events', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_uniform_transactions', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('employee_id');
            $table->text('notes')->nullable()->after('taken_at');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_uniform_transactions', function (Blueprint $table) {
            $table->dropColumn(['phone', 'notes']);
        });
    }
};
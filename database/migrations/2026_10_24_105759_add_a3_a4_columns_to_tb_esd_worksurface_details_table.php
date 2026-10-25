<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_esd_worksurface_details', function (Blueprint $table) {
            // A3 - Clear Acrylic Static Field Voltage (if any)
            $table->decimal('a3', 15, 2)->nullable()->after('judgement_a2');
            $table->string('judgement_a3', 10)->nullable()->after('a3');

            // A4.1 - A4.5 (Visual Inspection Checklist, boolean Yes/No)
            $table->boolean('a4_1')->nullable()->after('judgement_a3');
            $table->boolean('a4_2')->nullable()->after('a4_1');
            $table->boolean('a4_3')->nullable()->after('a4_2');
            $table->boolean('a4_4')->nullable()->after('a4_3');
            $table->boolean('a4_5')->nullable()->after('a4_4');
        });
    }

    public function down(): void
    {
        Schema::table('tb_esd_worksurface_details', function (Blueprint $table) {
            $table->dropColumn([
                'a3',
                'judgement_a3',
                'a4_1',
                'a4_2',
                'a4_3',
                'a4_4',
                'a4_5',
            ]);
        });
    }
};
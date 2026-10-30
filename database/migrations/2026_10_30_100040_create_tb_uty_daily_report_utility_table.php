<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_uty_daily_report_utility', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('shift')->comment('1, 2, 3');
            $table->enum('report_category', ['Schedule PM', 'Abnormality']);
            $table->text('problem_desc')->nullable();
            $table->json('photo_before')->nullable();
            $table->text('action_desc')->nullable();
            $table->json('photo_after')->nullable();
            $table->enum('status', ['Open', 'Under Maintenance', 'On Progress', 'Closed'])
                  ->default('Open');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['shift', 'status']);
            $table->index('report_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_uty_daily_report_utility');
    }
};
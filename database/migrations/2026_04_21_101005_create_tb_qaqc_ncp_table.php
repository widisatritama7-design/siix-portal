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
        Schema::create('tb_qaqc_ncp', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 50)->comment('Relasi ke employee');
            $table->string('section', 100)->nullable();
            $table->string('ncp_number', 100)->unique();
            $table->string('status', 50)->default('open')->comment('open, in_progress, closed, rejected');
            $table->string('file')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_qaqc_ncp');
    }
};
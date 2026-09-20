<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_qaqc_blind_test', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('shift', 50);
            $table->string('group', 50)->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('model_id');
            $table->json('blind_test_items')->nullable();
            $table->time('time_test')->nullable();
            $table->time('time_actual')->nullable();
            $table->unsignedBigInteger('check_by_qc')->nullable();
            $table->unsignedBigInteger('check_by_prod')->nullable();
            $table->unsignedBigInteger('acknowledge_by_spv')->nullable();
            $table->unsignedBigInteger('acknowledge_qc_spv')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->text('deleted_reason')->nullable();

            $table->index('employee_id');
            $table->index('customer_id');
            $table->index('model_id');
            $table->index(['shift', 'group']);

            $table->foreign('customer_id')->references('id')->on('tb_qaqc_customer')->onDelete('cascade');
            $table->foreign('model_id')->references('id')->on('tb_qaqc_model')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_qaqc_blind_test');
    }
};
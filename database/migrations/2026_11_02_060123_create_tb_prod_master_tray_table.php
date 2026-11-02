<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_prod_master_tray', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_rack_id')
                  ->constrained('tb_prod_master_rack')
                  ->cascadeOnDelete();
            $table->foreignId('master_locator_id')
                  ->nullable()
                  ->constrained('tb_prod_master_locator')
                  ->nullOnDelete();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('part_number_tray')->nullable();
            $table->string('item_code_sap')->nullable();
            $table->text('desc')->nullable();
            $table->string('model')->nullable();
            $table->integer('cav_tray')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_prod_master_tray');
    }
};
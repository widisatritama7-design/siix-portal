<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_prod_transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_tray_id')
                  ->constrained('tb_prod_master_tray')
                  ->cascadeOnDelete();
            $table->string('transaction_type'); // IN / OUT
            $table->integer('qty_in')->default(0);
            $table->integer('qty_out')->default(0);
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_prod_transaction');
    }
};
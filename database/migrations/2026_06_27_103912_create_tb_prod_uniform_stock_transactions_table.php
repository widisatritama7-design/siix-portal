<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tambahkan kolom qty ke tb_prod_master_uniform
        Schema::table('tb_prod_master_uniform', function (Blueprint $table) {
            $table->integer('qty')->default(0)->after('price');
        });

        // Buat tabel tb_prod_uniform_stock_transactions
        Schema::create('tb_prod_uniform_stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_uniform_id')->constrained('tb_prod_master_uniform')->onDelete('cascade');
            $table->enum('transaction_type', ['IN', 'OUT', 'OPNAME']);
            $table->integer('qty_change');
            $table->integer('qty_before');
            $table->integer('qty_after');
            $table->string('reference_id')->nullable();
            $table->string('reference_type')->nullable(); // 'uniform_request', 'stock_in', 'stock_opname'
            $table->text('description')->nullable();
            $table->string('performed_by')->nullable();
            $table->timestamp('performed_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_prod_uniform_stock_transactions');
        Schema::table('tb_prod_master_uniform', function (Blueprint $table) {
            $table->dropColumn('qty');
        });
    }
};
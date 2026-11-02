<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_prod_master_locator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_rack_id')
                  ->constrained('tb_prod_master_rack')
                  ->cascadeOnDelete();
            $table->string('locator_number');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->unique(['master_rack_id', 'locator_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_prod_master_locator');
    }
};
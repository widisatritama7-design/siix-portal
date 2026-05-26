<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_prod_uniform_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();
            $table->json('items');
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();
            
            $table->index('request_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_prod_uniform_requests');
    }
};
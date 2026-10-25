<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_esd_scissors', function (Blueprint $table) {
            $table->id();
            $table->string('register_no')->unique();
            $table->string('area');
            $table->string('location');
            $table->string('status')->default('In Use');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_esd_scissors');
    }
};
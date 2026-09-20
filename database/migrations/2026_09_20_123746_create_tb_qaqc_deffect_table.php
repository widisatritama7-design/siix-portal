<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_qaqc_deffect', function (Blueprint $table) {
            $table->id();
            $table->string('deffect_item_name');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index('deffect_item_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_qaqc_deffect');
    }
};
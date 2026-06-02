<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProdAbsenceControlTable extends Migration
{
    public function up()
    {
        Schema::create('tb_prod_absence_control', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id');
            $table->date('date');
            $table->string('actual_shift', 50)->nullable();
            $table->enum('status_date', ['Normal', 'Holiday'])->default('Normal');
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();
            
            $table->unique(['employee_id', 'date']);
            $table->index(['employee_id', 'date']);
            $table->index('date');
            $table->index('status_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_prod_absence_control');
    }
}
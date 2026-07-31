<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_prod_uniform_request_locks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id')->nullable(); // null untuk create mode
            $table->string('user_id');
            $table->string('user_name');
            $table->timestamp('locked_at');
            $table->timestamp('expires_at'); // timeout setelah 5 menit
            $table->string('session_id');
            $table->timestamps();
            
            $table->index(['request_id', 'session_id']);
            $table->index('expires_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_prod_uniform_request_locks');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_mtc_daily_panasonic_standard_check_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('standard_check_id')
                ->constrained('tb_mtc_daily_panasonic_standard_checks')
                ->onDelete('cascade')
                ->index('idx_panasonic_history_standard_id'); // Custom index name
            $table->foreignId('master_line_id')
                ->constrained('tb_mtc_master_lines')
                ->onDelete('cascade')
                ->index('idx_panasonic_history_master_line_id'); // Custom index name
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->index('idx_panasonic_history_user_id'); // Custom index name
            $table->enum('action', ['create', 'update']);
            $table->json('changes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            // Composite index with custom name
            $table->index(['standard_check_id', 'created_at'], 'idx_panasonic_history_check_created');
            $table->index('created_at', 'idx_panasonic_history_created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_mtc_daily_panasonic_standard_check_histories');
    }
};
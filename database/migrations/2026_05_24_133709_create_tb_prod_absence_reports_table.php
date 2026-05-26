<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_prod_absence_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->json('items'); // Berisi array: [{employee_id, group, line, jenis_ketidakhadiran, keterangan}, ...]
            
            // Approval flow
            $table->string('check_by', 100)->nullable();
            $table->timestamp('check_at')->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('accepted_by', 100)->nullable();
            $table->timestamp('accepted_at')->nullable();
            
            // Status: draft, checked, approved, accepted
            $table->enum('status', ['draft', 'checked', 'approved', 'accepted'])->default('draft');
            
            // Track user
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('report_number');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_prod_absence_reports');
    }
};
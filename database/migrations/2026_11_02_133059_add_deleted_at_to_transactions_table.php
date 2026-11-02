<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_prod_transaction', function (Blueprint $table) {
            // Soft delete
            $table->softDeletes(); 
            
            // Alasan penghapusan
            $table->text('delete_reason')->nullable()->after('reason');
        });
    }

    public function down(): void
    {
        Schema::table('tb_prod_transaction', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('delete_reason');
        });
    }
};
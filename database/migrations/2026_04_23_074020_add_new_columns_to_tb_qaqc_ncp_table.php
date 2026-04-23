<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_qaqc_ncp', function (Blueprint $table) {
            // Add new columns after 'remarks' column
            $table->string('part_description')->nullable()->after('remarks');
            $table->string('part_number')->nullable()->after('remarks');
            $table->string('supplier')->nullable()->after('remarks');
            $table->string('customer')->nullable()->after('remarks');
            $table->string('model_affected')->nullable()->after('remarks');
            $table->string('lot_no')->nullable()->after('remarks');
            $table->integer('lot_qty')->nullable()->after('remarks');
            $table->integer('rejected_qty')->nullable()->after('remarks');
            $table->decimal('failure_rate', 5, 2)->nullable()->after('rejected_qty');
            $table->json('defect_details')->nullable()->after('failure_rate');
            $table->string('do_no')->nullable()->after('defect_details');
            $table->string('packing_list_no')->nullable()->after('do_no');
            $table->string('disposition')->nullable()->after('packing_list_no');
            $table->unsignedBigInteger('approved_by')->nullable()->after('disposition');
            
            // Add foreign key constraint for approved_by
            $table->foreign('approved_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_qaqc_ncp', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['approved_by']);
            
            // Drop columns
            $table->dropColumn([
                'part_description',
                'part_number',
                'supplier',
                'customer',
                'model_affected',
                'lot_no',
                'lot_qty',
                'rejected_qty',
                'failure_rate',
                'defect_details',
                'do_no',
                'packing_list_no',
                'disposition',
                'approved_by'
            ]);
        });
    }
};
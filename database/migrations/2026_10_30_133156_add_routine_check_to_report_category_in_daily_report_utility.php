<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE tb_uty_daily_report_utility MODIFY COLUMN report_category ENUM('Schedule PM', 'Abnormality', 'Routine Check')");
    }

    public function down()
    {
        DB::statement("ALTER TABLE tb_uty_daily_report_utility MODIFY COLUMN report_category ENUM('Schedule PM', 'Abnormality')");
    }
};

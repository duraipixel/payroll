<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_bank_loans', function (Blueprint $table) {
            $table->text('file')->nullable()->after('status');
            $table->date('loan_start_date')->nullable()->after('file');
            $table->date('loan_end_date')->nullable()->after('loan_start_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_bank_loans', function (Blueprint $table) {
            $table->dropColumn('file');
            $table->dropColumn('loan_start_date');
            $table->dropColumn('loan_end_date');
        });
    }
};

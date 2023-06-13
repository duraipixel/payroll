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
        Schema::table('staff_salary_patterns', function (Blueprint $table) {
            $table->date('payout_month')->nullable();
            $table->text('remarks')->after('payout_month')->nullable();
            $table->text('employee_remarks')->after('remarks')->nullable();
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_salary_patterns', function (Blueprint $table) {
            $table->dropColumn('payout_month');
            $table->dropColumn('remarks');
            $table->dropColumn('employee_remarks');
            $table->dropColumn('verification_status');
        });
    }
};

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
            $table->timestamp('approved_on')->nullable();
            $table->timestamp('rejected_on')->nullable();
            $table->unsignedBigInteger('rejectedBy')->nullable();
            $table->text('approved_remarks')->nullable();
            $table->text('removed_remarks')->nullable();
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
            $table->dropColumn('approved_on');
            $table->dropColumn('rejected_on');
            $table->dropColumn('rejectedBy');
            $table->dropColumn('approved_remarks');
            $table->dropColumn('removed_remarks');
        });
    }
};

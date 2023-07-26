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
        Schema::table('staff_salaries', function (Blueprint $table) {
            $table->integer('working_days')->nullable();
            $table->integer('worked_days')->nullable();
            $table->integer('leave_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_salaries', function (Blueprint $table) {
            $table->dropColumn('working_days');
            $table->dropColumn('worked_days');
            $table->dropColumn('leave_days');
        });
    }
};

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
            $table->text('other_description')->nullable();
            $table->text('employee_description')->nullable();
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
            $table->dropColumn('other_description');
            $table->dropColumn('employee_description');
        });
    }
};

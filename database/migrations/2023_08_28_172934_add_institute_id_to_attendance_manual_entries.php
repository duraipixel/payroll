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
        Schema::table('attendance_manual_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('institute_id')->nullable();
            $table->string('institute_emp_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_manual_entries', function (Blueprint $table) {
            $table->dropColumn('institute_id');
            $table->dropColumn('institute_emp_code');
        });
    }
};

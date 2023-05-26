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
        Schema::table('attendance_schemes', function (Blueprint $table) {
            $table->unsignedBigInteger('institute_id')->nullable('name');
            $table->string('scheme_code')->nullable('institute_id');
            $table->time('start_time')->nullable('scheme_code');
            $table->time('end_time')->nullable('start_time');
            $table->time('totol_hours')->nullable('end_time');
            $table->time('late_cutoff_time')->nullable('late_cutoff_time');
            $table->time('permission_cutoff_time')->nullable('late_cutoff_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_schemes', function (Blueprint $table) {
            $table->dropColumn('institute_id');
            $table->dropColumn('scheme_code');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('totol_hours');
            $table->dropColumn('late_cutoff_time');
            $table->dropColumn('permission_cutoff_time');
        });
    }
};

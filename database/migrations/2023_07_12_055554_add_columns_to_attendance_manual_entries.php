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
            $table->time('from_time')->nullable(true)->change();
            $table->time('to_time')->nullable(true)->change();
            $table->time('total_time')->nullable();
            $table->time('total_worked')->nullable();
            $table->time('duty_duration')->nullable();
            $table->time('break_out')->nullable();
            $table->time('break_in')->nullable();
            $table->time('break_duration')->nullable();
            $table->time('actual_break')->nullable();
            $table->unsignedBigInteger('reporting_manager')->nullable(true)->change();
            $table->string('attendance_status')->change();
            $table->longText('reason')->nullable()->change();
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
            $table->dropColumn('total_time');
            $table->dropColumn('total_worked');
            $table->dropColumn('duty_duration');
            $table->dropColumn('break_out');
            $table->dropColumn('break_in');
            $table->dropColumn('break_duration');
            $table->dropColumn('actual_break');
        });
    }
};

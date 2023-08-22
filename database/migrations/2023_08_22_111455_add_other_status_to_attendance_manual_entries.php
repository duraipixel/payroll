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
            $table->string('other_status')->nullable();
            $table->time('clock_in')->nullable();
            $table->time('clock_out')->nullable();
            $table->time('total_clocked_time')->nullable();
            $table->time('unscheduled')->nullable();
            $table->longText('api_response')->nullable();
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
            $table->dropColumn('other_status');
            $table->dropColumn('clock_in');
            $table->dropColumn('clock_out');
            $table->dropColumn('total_clocked_time');
            $table->dropColumn('unscheduled');
            $table->dropColumn('api_response');
        });
    }
};

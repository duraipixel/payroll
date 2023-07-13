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
            $table->index('attendance_date');
            $table->index('attendance_status');
            $table->index('from_time');
            $table->index('to_time');
            $table->index('employment_id');
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
            $table->dropIndex('attendance_date');
            $table->dropIndex('attendance_status');
            $table->dropIndex('from_time');
            $table->dropIndex('to_time');
            $table->dropIndex('employment_id');
        });
    }
};

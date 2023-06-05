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
        Schema::table('staff_education_details', function (Blueprint $table) {
            $table->timestamp('approved_date')->nullable()->after('verification_status');
            $table->timestamp('rejected_date')->nullable()->after('approved_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_education_details', function (Blueprint $table) {
            //
        });
    }
};

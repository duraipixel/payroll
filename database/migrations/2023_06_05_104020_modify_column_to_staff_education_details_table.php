<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            try {
                DB::transaction(function () {
                    DB::statement("ALTER TABLE `staff_education_details` MODIFY COLUMN `verification_status` ENUM('pending', 'approved', 'rejected')");
                });
            } catch (Exception $e) {
                DB::rollBack();
            }
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

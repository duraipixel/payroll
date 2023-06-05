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
        Schema::table('staff_work_experiences', function (Blueprint $table) {
            try {
                DB::transaction(function () {
                    DB::statement("ALTER TABLE `staff_work_experiences` MODIFY COLUMN `verification_status` ENUM('pending', 'approved', 'rejected')");
                });
            } catch (Exception $e) {
                DB::rollBack();
            }

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
        Schema::table('staff_work_experiences', function (Blueprint $table) {
            //
        });
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('institute_id')->nullable();
            $table->string('society_emp_code')->nullable();
            $table->string('institute_emp_code')->nullable();
            $table->string('emp_code')->nullable();
            $table->string('first_name')->nullable();
            $table->string('first_name_tamil')->nullable();
            $table->string('last_name')->nullable();
            $table->string('short_name')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('reporting_manager_id')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('profile_status')->nullable();            
            $table->enum('verification_status', ['approved', 'draft', 'rejected', 'cancelled', 'pending'])->default('pending');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('is_super_admin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

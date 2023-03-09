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
        Schema::create('staff_appointment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('nature_of_employment_id');
            $table->unsignedBigInteger('teaching_type_id');
            $table->unsignedBigInteger('place_of_work_id');
            $table->date('joining_date')->nullable();
            $table->float('salary_scale')->nullable()->comment('for appointment order purpose and not for salary calculation');
            $table->date('from_appointment')->nullable();
            $table->date('to_appointment')->nullable();
            $table->unsignedBigInteger('appointment_order_model_id');
            $table->enum('has_probation', ['yes', 'no']);
            $table->text('appointment_doc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_appointment_details');
    }
};

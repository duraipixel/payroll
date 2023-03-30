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
        Schema::create('staff_health_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('bloodgroup_id');
            $table->float('height');
            $table->float('weight');
            $table->string('identification_mark');
            $table->string('identification_mark1');
            $table->string('identification_mark2');
            $table->enum('disease_allergy', ['yes', 'no']);
            $table->enum('differently_abled', ['yes', 'no']);
            $table->string('family_doctor_name')->nullable();
            $table->string('family_doctor_contact_no')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('staff_health_details');
    }
};

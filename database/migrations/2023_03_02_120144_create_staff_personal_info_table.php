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
        Schema::create('staff_personal_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->date('dob');
            $table->string('mother_tongue');
            $table->enum('gender', ['male', 'female', 'others']);
            $table->enum('marital_status', ['married', 'single', 'divorced']);
            $table->date('marriage_date')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('mobile_no1')->nullable();
            $table->string('mobile_no2')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('emergency_no')->nullable();
            $table->string('birth_place')->nullable();
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->unsignedBigInteger('religion_id')->nullable();
            $table->unsignedBigInteger('caste_id')->nullable();
            $table->unsignedBigInteger('community_id')->nullable();
            $table->text('contact_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('staff_personal_info');
    }
};

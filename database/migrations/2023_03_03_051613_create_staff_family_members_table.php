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
        Schema::create('staff_family_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('relation_type_id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('dob');
            $table->enum('gender', ['male', 'female', 'others']);
            $table->integer('age')->nullable();
            $table->unsignedBigInteger('qualification_id')->nullable();
            $table->unsignedBigInteger('profession_type_id')->nullable();
            $table->unsignedBigInteger('blood_group_id')->nullable();
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->string('premises')->nullable()->comment('amalarpavam', 'others');
            $table->text('remarks')->nullable();
            $table->text('residential_address')->nullable();
            $table->text('occupational_address')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('staff_family_members');
    }
};

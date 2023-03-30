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
        Schema::create('staff_education_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->string('course_name');
            $table->date('course_completed_year');
            $table->unsignedBigInteger('board_id');
            $table->unsignedBigInteger('main_subject_id');
            $table->unsignedBigInteger('ancillary_subject_id');
            $table->string('certificate_no');
            $table->date('submitted_date')->nullable();
            $table->string('education_type')->nullable()->comment('academic', 'professional');
            $table->text('doc_file')->nullable();
            $table->text('multi_file')->nullable();
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
        Schema::dropIfExists('staff_education_details');
    }
};

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
        Schema::create('staff_concessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('student_reg_no')->nullable();
            $table->unsignedBigInteger('student_class_id');
            $table->float('annual_fees')->nullable();
            $table->float('annual_fees_concession')->nullable();
            $table->float('annual_fees_after_concession')->nullable();
            $table->float('exam_fees')->nullable();
            $table->float('exam_fees_concession')->nullable();
            $table->float('exam_fees_after_concession')->nullable();
            $table->float('lab_fees')->nullable();
            $table->float('lab_fees_concession')->nullable();
            $table->float('lab_fees_after_concession')->nullable();
            $table->float('total_fees')->nullable();
            $table->float('total_fees_concession')->nullable();
            $table->float('total_fees_after_concession')->nullable();
            $table->text('file')->nullable();
            $table->enum('approval_status', ['approved', 'rejected', 'pending']);
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
        Schema::dropIfExists('staff_concessions');
    }
};

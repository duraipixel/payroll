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
        Schema::create('staff_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id');
            $table->unsignedBigInteger('staff_id');
            $table->string('designation')->nullable();
            $table->string('place_of_work')->nullable();
            $table->decimal('salary', 15,2)->nullable();
            $table->string('leave_category');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('no_of_days')->nullable();
            $table->date('holiday_date')->nullable();
            $table->date('holiday_date2')->nullable();
            $table->date('holiday_date3')->nullable();
            $table->integer('no_of_holidays')->nullable();
            $table->unsignedBigInteger('leave_category_id')->nullable();
            $table->text('reason')->nullable();
            $table->text('address')->nullable();
            $table->enum('is_granted',['yes', 'no'])->nullable();
            $table->date('granted_start_date')->nullable();
            $table->date('granted_end_date')->nullable();
            $table->integer('granted_days')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('granted_by')->nullable();
            $table->string('granted_designation')->nullable();
            $table->unsignedBigInteger('reporting_id')->nullable();
            $table->text('document')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->unsignedBigInteger('addedBy')->nullable();
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
        Schema::dropIfExists('staff_leaves');
    }
};

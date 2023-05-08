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
        Schema::create('reporting_managers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id');
            $table->unsignedBigInteger('reportee_id');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('institute_id')->nullable();
            $table->date('assigned_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('is_top_level', ['yes', 'no'])->default('no');
            $table->string('status');
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
        Schema::dropIfExists('reporting_managers');
    }
};

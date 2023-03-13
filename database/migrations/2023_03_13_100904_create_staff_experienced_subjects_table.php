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
        Schema::create('staff_experienced_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('subject_id');
            $table->enum('status', ['active', 'inactive']);
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
        Schema::dropIfExists('staff_experienced_subjects');
    }
};

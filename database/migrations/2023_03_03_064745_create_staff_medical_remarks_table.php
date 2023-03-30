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
        Schema::create('staff_medical_remarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->date('medic_date');
            $table->text('reason');
            $table->text('medic_documents');
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
        Schema::dropIfExists('staff_medical_remarks');
    }
};

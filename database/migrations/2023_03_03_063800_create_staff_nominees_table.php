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
        Schema::create('staff_nominees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('nominee_id');
            $table->unsignedBigInteger('relationship_type_id');
            $table->date('dob');
            $table->enum('gender', ['male', 'female', 'others']);
            $table->integer('age');
            $table->string('minor_name')->nullable();
            $table->float('share')->nullable();
            $table->text('minor_address')->nullable();
            $table->string('minor_contact_no')->nullable();
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
        Schema::dropIfExists('staff_nominees');
    }
};

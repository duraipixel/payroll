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
        Schema::create('staff_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('institue_id');
            $table->unsignedBigInteger('designation_id');
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->string('period')->nullable()->comment('from - to dates');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->text('address');
            $table->float('salary_drawn');
            $table->integer('experience_year')->nullable();
            $table->integer('experience_month')->nullable();
            $table->text('remarks')->nullable();
            $table->text('doc_file')->nullable();

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
        Schema::dropIfExists('staff_work_experiences');
    }
};

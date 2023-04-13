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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->string('title');
            $table->string('academic_year');
            $table->string('date');
            $table->string('day');
            $table->enum('is_open_to_all', ['yes', 'no'])->default('no');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('added_by')->nullable();
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
        Schema::dropIfExists('holidays');
    }
};

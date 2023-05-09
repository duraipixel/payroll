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
        Schema::create('role_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->integer('staff_id');
            $table->integer('role_id');
            $table->integer('role_created_id');
            $table->integer('sort_order')->nullable();
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
        Schema::dropIfExists('role_mappings');
    }
};

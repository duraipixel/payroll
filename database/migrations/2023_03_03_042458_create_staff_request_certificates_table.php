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
        Schema::create('staff_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('certificate_type_id');
            $table->string('purpose');
            $table->date('issue_date');
            $table->date('return_date');
            $table->text('remarks');
            $table->text('file')->nullable();
            $table->enum('approval_status', ['pending', 'rejected', 'cancelled', 'approved', 'requested']);
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('staff_request_certificates');
    }
};

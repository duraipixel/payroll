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
        Schema::create('staff_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id');
            $table->unsignedBigInteger('staff_id');
            $table->string('designation')->nullable();
            $table->date('permission_date');
            $table->time('from_time');
            $table->time('to_time');
            $table->integer('no_of_minutes')->nullable();
            $table->text('reason')->nullable();
            $table->date('granted_at')->nullable();
            $table->unsignedBigInteger('granted_by')->nullable();
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
        Schema::dropIfExists('staff_permissions');
    }
};

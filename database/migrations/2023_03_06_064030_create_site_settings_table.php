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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('mobile_no')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('optional_email')->nullable();
            $table->text('address')->nullable();
            $table->text('favicon')->nullable();
            $table->text('logo')->nullable();
            $table->text('logo1')->nullable();
            $table->text('copyrights')->nullable();
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
        Schema::dropIfExists('site_settings');
    }
};

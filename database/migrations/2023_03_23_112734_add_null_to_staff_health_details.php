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
        Schema::table('staff_health_details', function (Blueprint $table) {
            $table->string('identification_mark1')->nullable(true)->change();
            $table->string('identification_mark2')->nullable(true)->change();
            $table->string('disease_allergy')->nullable(true)->change();
            $table->string('differently_abled')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_health_details', function (Blueprint $table) {
            $table->string('identification_mark1')->nullable(false)->change();
            $table->string('identification_mark2')->nullable(false)->change();
            $table->string('disease_allergy')->nullable(false)->change();
            $table->string('differently_abled')->nullable(false)->change();
        });
    }
};

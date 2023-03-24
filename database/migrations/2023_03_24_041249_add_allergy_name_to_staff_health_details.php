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
            $table->string('disease_allergy_name')->nullable();
            $table->string('differently_abled_name')->nullable();
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
            $table->dropColumn('disease_allergy_name');
            $table->dropColumn('differently_abled_name');
        });
    }
};

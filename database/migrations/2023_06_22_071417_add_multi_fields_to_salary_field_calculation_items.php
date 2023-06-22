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
        Schema::table('salary_field_calculation_items', function (Blueprint $table) {
            $table->unsignedBigInteger('field_id')->nullable(true)->change();
            $table->string('multi_field_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_field_calculation_items', function (Blueprint $table) {
            $table->dropColumn('multi_field_id');
        });
    }
};

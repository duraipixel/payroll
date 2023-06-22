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
        Schema::table('staff_salary_patterns', function (Blueprint $table) {
            $table->unsignedBigInteger('addedBy')->nullable();
            $table->unsignedBigInteger('lastUpdatedBy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_salary_patterns', function (Blueprint $table) {
            $table->dropColumn('addedBy');
            $table->dropColumn('lastUpdatedBy');
        });
    }
};

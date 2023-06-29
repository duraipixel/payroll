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
        Schema::table('it_staff_statements', function (Blueprint $table) {
            $table->enum('is_staff_calculation_done', ['yes', 'no'])->default('no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('it_staff_statements', function (Blueprint $table) {
            $table->dropColumn('is_staff_calculation_done');
        });
    }
};

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
        Schema::table('salary_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('salary_head_id');
            $table->enum('entry_type', ['manual', 'calculation']);
            $table->integer('no_of_numerals')->nullable();
            $table->integer('order_in_salary_slip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_fields', function (Blueprint $table) {
            $table->dropColumn('salary_head_id');
            $table->dropColumn('entry_type');
            $table->dropColumn('no_of_numerals');
            $table->dropColumn('order_in_salary_slip');
        });
    }
};

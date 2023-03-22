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
        Schema::table('staff_known_languages', function (Blueprint $table) {
            $table->boolean('read')->default(false)->change();
            $table->boolean('write')->default(false)->change();
            $table->boolean('speak')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_known_languages', function (Blueprint $table) {
            //
        });
    }
};

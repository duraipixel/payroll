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
        Schema::table('gratuities', function (Blueprint $table) {
            $table->string('page_type')->nullable();
            $table->string('gratuity_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gratuities', function (Blueprint $table) {
            $table->dropColumn('page_type');
            $table->dropColumn('gratuity_type');
        });
    }
};

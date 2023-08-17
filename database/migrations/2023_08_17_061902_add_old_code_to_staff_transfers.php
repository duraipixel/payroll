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
        Schema::table('staff_transfers', function (Blueprint $table) {
            $table->string('old_institution_code')->nullable();
            $table->string('new_institution_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_transfers', function (Blueprint $table) {
            $table->dropColumn('old_institution_code');
            $table->dropColumn('new_institution_code');
        });
    }
};

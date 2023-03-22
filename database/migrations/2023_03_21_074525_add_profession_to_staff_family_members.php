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
        Schema::table('staff_family_members', function (Blueprint $table) {
            $table->string('profession')->nullable()->after('profession_type_id');
            $table->string('contact_no')->after('profession')->nullable();
            $table->string('registration_no')->after('profession')->nullable();
            $table->string('standard')->after('profession')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_family_members', function (Blueprint $table) {
            $table->dropColumn('profession');
            $table->dropColumn('contact_no');
            $table->dropColumn('registration_no');
            $table->dropColumn('standard');
        });
    }
};

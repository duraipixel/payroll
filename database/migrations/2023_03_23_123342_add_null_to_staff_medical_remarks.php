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
        Schema::table('staff_medical_remarks', function (Blueprint $table) {
            $table->text('medic_documents')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_medical_remarks', function (Blueprint $table) {
            $table->text('medic_documents')->nullable(false)->change();
        });
    }
};

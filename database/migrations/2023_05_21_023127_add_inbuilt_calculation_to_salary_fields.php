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
            $table->string('entry_type')->change()->nullable()->comment('manual, calculation, inbuilt_calculation');
            $table->enum('is_static', ['yes', 'no'])->default('no');
        });
    }

    public function down()
    {
        Schema::table('salary_fields', function (Blueprint $table) {
            // $table->enum('entry_type', ['manual', 'calculation'])->change();
            $table->dropColumn('is_static');
        });
    }
};

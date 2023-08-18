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
        Schema::table('staff_salary_pattern_fields', function (Blueprint $table) {
            $table->index('staff_id');
            $table->index('staff_salary_pattern_id');
            $table->index('field_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_salary_pattern_fields', function (Blueprint $table) {
            $table->dropIndex(['staff_id']);
            $table->dropIndex(['staff_salary_pattern_id']);
            $table->dropIndex(['field_id']);
        });
    }
};

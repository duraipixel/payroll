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
        Schema::table('salary_heads', function (Blueprint $table) {
            $table->enum('is_static', ['yes', 'no'])->nullable()->default('no')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_heads', function (Blueprint $table) {
            $table->dropColumn('is_static');
        });
    }
};

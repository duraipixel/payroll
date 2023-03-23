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
        Schema::table('staff_working_relations', function (Blueprint $table) {
            $table->unsignedBigInteger('relationship_type_id')->nullable()->after('status');
            $table->string('belonger_code')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_working_relations', function (Blueprint $table) {
            $table->dropColumn('relationship_type_id');
            $table->unsignedBigInteger('belonger_code')->change();

        });
    }
};

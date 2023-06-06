<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salary_approval_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->integer('salary_id');
            $table->integer('approved_by');
            $table->string('approval_status');
            $table->date('approval_date'); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_approval_logs');
    }
};

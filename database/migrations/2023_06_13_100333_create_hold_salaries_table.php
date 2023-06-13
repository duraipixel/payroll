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
        Schema::create('hold_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->string('hold_reason')->nullable();
            $table->date('hold_month')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('hold_at')->nullable();
            $table->unsignedBigInteger('hold_by')->nullable();
            $table->timestamp('release_at')->nullable();
            $table->unsignedBigInteger('released_by')->nullable();
            $table->text('release_remarks')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hold_salaries');
    }
};

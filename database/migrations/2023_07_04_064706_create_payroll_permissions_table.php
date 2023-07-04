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
        Schema::create('payroll_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->date('payout_month')->nullable();
            $table->enum('payroll_inputs',['lock', 'unlock'])->nullable();
            $table->enum('emp_view_release',['lock', 'unlock'])->nullable();
            $table->enum('it_statement_view',['lock', 'unlock'])->nullable();
            $table->enum('payroll',['lock', 'unlock'])->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_permissions');
    }
};

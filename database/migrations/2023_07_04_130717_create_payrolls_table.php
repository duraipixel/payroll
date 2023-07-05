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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->date('payroll_date')->nullable()->comment('final payroll process date');
            $table->date('modified_date')->nullable();
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
            $table->string('name')->nullable();
            $table->date('employee_loc_date')->nullable();
            $table->date('employee_it_view_lock_date')->nullable();
            $table->date('payroll_input_loc_date')->nullable();
            $table->date('payroll_lock_date')->nullable();
            $table->date('payroll_release_date')->nullable();
            $table->date('payroll_input_release_date')->nullable();
            $table->date('employee_release_date')->nullable();
            $table->date('employee_it_view_release_date')->nullable();
            $table->enum('locked', ['yes', 'no'])->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};

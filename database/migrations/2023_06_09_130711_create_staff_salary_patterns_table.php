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
        Schema::create('staff_salary_patterns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->string('salary_no')->nullable();
            $table->decimal('total_earnings', 15,2)->default(0);
            $table->decimal('total_deductions', 15,2)->default(0);
            $table->decimal('gross_salary', 15,2)->default(0);
            $table->decimal('net_salary', 15,2)->default(0);
            $table->string('salary_month')->nullable();
            $table->string('salary_year')->nullable();
            $table->date('effective_from')->nullable();
            $table->enum('is_salary_processed', ['yes', 'no']);
            $table->unsignedBigInteger('salary_approved_by')->nullable();
            $table->timestamp('salary_processed_on')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_salary_patterns');
    }
};

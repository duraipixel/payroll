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
        Schema::create('staff_salary_pre_earnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->date('salary_month');
            $table->decimal('amount', 12,2);
            $table->text('remarks')->nullable();
            $table->enum('earnings_type', ['bonus', 'allowance', 'arrear', 'other']);
            $table->enum('status', ['active', 'inactive', 'paid'])->default('active');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->enum('is_verified', ['yes', 'no'])->default('yes');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_salary_pre_earnings');
    }
};

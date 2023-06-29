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
        Schema::create('it_staff_statements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('pan_no')->nullable();
            $table->integer('no_of_months')->nullable();
            $table->decimal('gross_salary_anum', 12,2)->nullable();
            $table->decimal('standard_deduction', 12,2)->nullable();
            $table->decimal('hra', 12,2)->nullable();
            $table->decimal('total_year_salary_income', 12,2)->nullable();
            $table->decimal('housing_loan_interest', 12,2)->nullable();
            $table->decimal('professional_tax', 12,2)->nullable();
            $table->decimal('total_extract_from_housing_loan_interest', 12,2)->nullable();
            $table->decimal('total_extract_from_professional_tax', 12,2)->nullable();
            $table->decimal('other_income', 12,2)->nullable();
            $table->decimal('gross_income', 12,2)->nullable();
            $table->decimal('deduction_80c_amount', 12,2)->nullable();
            $table->decimal('national_pension_amount', 12,2)->nullable();
            $table->decimal('medical_policy_amount', 12,2)->nullable();
            $table->decimal('bank_interest_deduction_amount', 12,2)->nullable();
            $table->decimal('total_deduction_amount', 12,2)->nullable();
            $table->decimal('taxable_gross_income', 12,2)->nullable();
            $table->decimal('round_off_taxable_gross_income', 12,2)->nullable();
            $table->decimal('tax_on_taxable_gross_income', 12,2)->nullable();
            $table->decimal('tax_after_rebate_amount', 12,2)->nullable();
            $table->decimal('educational_cess_tax_payable', 12,2)->nullable();
            $table->decimal('total_income_tax_payable', 12,2)->nullable();
            $table->text('document')->nullable();
            $table->enum('status',['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('it_staff_statements');
    }
};

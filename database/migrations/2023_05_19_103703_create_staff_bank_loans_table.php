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
        Schema::create('staff_bank_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('loan_ac_no')->nullable();
            $table->unsignedBigInteger('loan_type_id')->nullable();
            $table->enum('loan_due', ['fixed', 'variable'])->nullable();
            $table->decimal('every_month_amount', 15,2)->nullable();
            $table->integer('period_of_loans')->nullable()->comment('in total month to pay');
            $table->enum('status', ['active', 'inactive', 'completed']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_bank_loans');
    }
};

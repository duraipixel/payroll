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
        Schema::create('gratuities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('institution_id')->nullable();
            $table->string('husband_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('last_post_held')->nullable();
            $table->date('date_of_regularizion')->nullable()->comment('last appointment start date');
            $table->date('date_of_ending_service')->nullable();
            $table->string('cause_of_ending_service')->nullable()->comment('Superannuation,Due to medical ground,Invalid on medical ground,Death,retired,resigned');
            $table->string('gross_service')->nullable();
            $table->string('gross_service_year')->nullable();
            $table->string('gross_service_month')->nullable();
            $table->string('extraordinary_leave')->nullable();
            $table->string('net_qualifying_service')->nullable();
            $table->string('qualify_service_expressed ')->nullable();
            $table->decimal('total_emuluments', 12,2);
            $table->decimal('gratuity_calculation', 12,2);
            $table->string('gratuity_nomination_name')->nullable();
            $table->string('gratuity_nomination_type')->nullable();
            $table->string('gratuity_nomination_contact_details')->nullable();
            $table->string('gratuity_nomination_address')->nullable();
            $table->decimal('total_payable_gratuity', 12, 2)->nullable();
            $table->string('mode_of_payment')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('settlement_status ', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->enum('verification_status', ['verified', 'failed', 'pending'])->default('pending');
            $table->date('settlement_date')->nullable();
            $table->date('date_of_issue')->nullable();
            $table->text('issue_remarks')->nullable();
            $table->text('issue_attachment')->nullable();
            $table->text('payment_remarks')->nullable();
            $table->text('payment_attachment')->nullable();
            $table->unsignedBigInteger('approved_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gratuities');
    }
};

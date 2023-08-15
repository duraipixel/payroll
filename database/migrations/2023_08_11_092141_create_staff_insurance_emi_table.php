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
        Schema::create('staff_insurance_emi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('staff_insurance_id')->nullable();
            $table->date('emi_date');
            $table->date('emi_month')->nullable();
            $table->decimal('amount', 12,2);
            $table->string('insurance_mode')->comment('fixed, variable')->nullable();
            $table->string('insurance_type')->comment('lic,hdfc,medical,health')->nullable();
            $table->enum('status', ['active','inactive', 'paid']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_insurance_emi');
    }
};

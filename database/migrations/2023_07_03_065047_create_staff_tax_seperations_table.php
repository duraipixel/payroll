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
        Schema::create('staff_tax_seperations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('income_tax_id')->nullable();
            $table->decimal('april', 12,2)->nullable();
            $table->decimal('may', 12,2)->nullable();
            $table->decimal('june', 12,2)->nullable();
            $table->decimal('july', 12,2)->nullable();
            $table->decimal('august', 12,2)->nullable();
            $table->decimal('september', 12,2)->nullable();
            $table->decimal('october', 12,2)->nullable();
            $table->decimal('november', 12,2)->nullable();
            $table->decimal('december', 12,2)->nullable();
            $table->decimal('january', 12,2)->nullable();
            $table->decimal('february', 12,2)->nullable();
            $table->decimal('march', 12,2)->nullable();
            $table->decimal('total_tax', 12,2)->nullable();
            $table->decimal('balance', 12,2)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_tax_seperations');
    }
};

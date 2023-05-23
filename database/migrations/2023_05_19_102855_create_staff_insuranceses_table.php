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
        Schema::create('staff_insuranceses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->string('insurance_name')->nullable();
            $table->string('policy_no')->nullable();
            $table->decimal('amount', 15,2);
            $table->date('maturity_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->text('file')->nullable();
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
        Schema::dropIfExists('staff_insuranceses');
    }
};

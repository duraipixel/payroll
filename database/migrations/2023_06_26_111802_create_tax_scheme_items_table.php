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
        Schema::create('tax_section_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id')->nullable();
            $table->date('financial_start')->nullable();
            $table->date('financial_end')->nullable();
            $table->unsignedBigInteger('tax_scheme_id');
            $table->string('name');
            $table->enum('is_proof',['yes', 'no'])->default('no');
            $table->text('proof_document')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('reference_salary_field_id')->nullable();
            $table->string('reference_slug')->nullable();
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
        Schema::dropIfExists('tax_section_items');
    }
};

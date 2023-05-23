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
        Schema::create('salary_field_calculation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_field_id');
            $table->unsignedBigInteger('field_id');
            $table->string('field_name')->nullable();
            $table->decimal('percentage', 12,2);
            $table->string('order_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_field_calculation_items');
    }
};

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
        Schema::create('professional_tax_slabs', function (Blueprint $table) {
            $table->id();
            $table->decimal('from_amount', 15,2);
            $table->decimal('to_amount', 15,2);
            $table->decimal('tax_fee', 15,2);
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
        Schema::dropIfExists('professional_tax_slabs');
    }
};

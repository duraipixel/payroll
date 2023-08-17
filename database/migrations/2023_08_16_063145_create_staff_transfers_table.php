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
        Schema::create('staff_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_id');
            $table->unsignedBigInteger('from_institution_id');
            $table->unsignedBigInteger('to_institution_id');
            $table->unsignedBigInteger('staff_id');
            $table->text('remarks')->nullable();
            $table->text('reason')->nullable();
            $table->date('effective_from')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_transfers');
    }
};

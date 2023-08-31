<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('gratuity_el_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gratuity_el_id');
            $table->date('el_from_year')->nullable();
            $table->date('el_to_year')->nullable();
            $table->integer('total_leave')->nullable();
            $table->integer('taken_leave')->nullable();
            $table->text('leave_description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('gratuity_el_items');
    }

};

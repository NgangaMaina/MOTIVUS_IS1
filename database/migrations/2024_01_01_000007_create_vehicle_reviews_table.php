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
        Schema::create('vehicle_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->integer('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('booking_id');
            $table->index('rating');
            
            // Note: Rating validation should be handled in the model/controller
            // MySQL check constraint: ALTER TABLE vehicle_reviews ADD CONSTRAINT chk_rating CHECK (rating >= 1 AND rating <= 5);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_reviews');
    }
};

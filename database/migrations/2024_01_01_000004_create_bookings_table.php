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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['pending', 'accepted', 'completed', 'cancelled', 'rejected'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('renter_id');
            $table->index('vehicle_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
            
            // Note: Date validation should be handled in the model/controller
            // MySQL check constraint: ALTER TABLE bookings ADD CONSTRAINT chk_dates CHECK (end_date >= start_date);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

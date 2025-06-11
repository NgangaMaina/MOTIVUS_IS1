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
        Schema::create('delivery_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['assigned', 'en_route', 'delivered'])->default('assigned');
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('booking_id');
            $table->index('driver_id');
            $table->index('status');
            $table->index('delivered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_tasks');
    }
};

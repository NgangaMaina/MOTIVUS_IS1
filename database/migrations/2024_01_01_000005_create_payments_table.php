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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('transaction_code', 100)->unique();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['success', 'failed', 'pending'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('booking_id');
            $table->index('transaction_code');
            $table->index('status');
            $table->index('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('make', 50);
            $table->string('model', 50);
            $table->integer('year')->nullable();
            $table->string('location', 100);
            $table->decimal('price_per_day', 10, 2);
            $table->boolean('availability')->default(true);
            $table->text('image_url')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('owner_id');
            $table->index('availability');
            $table->index(['make', 'model']);
            $table->index('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};

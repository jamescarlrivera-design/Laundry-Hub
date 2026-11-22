<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_items', function (Blueprint $table) {
            $table->id();

            // Parent request
            $table->foreignId('request_id')
                  ->constrained('requests')
                  ->cascadeOnDelete();

            // Selected laundry service
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->restrictOnDelete();

            $table->enum('request_method', [
            'walk_in',
            'pickup'
             ])->default('walk_in');

            $table->decimal('pickup_fee', 10, 2)->default(0);

            // Amount of the selected service
            $table->decimal('quantity', 10, 2);

            // Price when the customer placed the order
            $table->decimal('unit_price', 10, 2);

            // quantity multiplied by unit_price
            $table->decimal('subtotal', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_items');
    }
};

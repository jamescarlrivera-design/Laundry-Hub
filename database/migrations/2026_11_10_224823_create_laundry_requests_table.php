<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            

            // Customer who created the request
            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            // Total price of all requested services
            $table->decimal('total_amount', 10, 2)->default(0);

            // Current status of the laundry request
            $table->enum('status', [
                'pending',
                'approved',
                'processing',
                'completed',
                'cancelled',
            ])->default('pending');
             $table->foreignId('pickup_information_id')
              ->nullable()
              ->constrained('pickup_information')
              ->nullOnDelete();
            $table->enum('fulfillment_type', ['pickup', 'walk_in'])
            ->default('walk_in');
            $table->decimal('fulfillment_fee', 10, 2)->default(0);
            $table->text('notes')->nullable();
        
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};

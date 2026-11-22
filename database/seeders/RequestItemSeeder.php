<?php

namespace Database\Seeders;

use App\Models\LaundryRequest;
use App\Models\Service;
use Illuminate\Database\Seeder;

class RequestItemSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::where('status', 'active')->get();
        $requests = LaundryRequest::all();

        // Stop if there are no services or requests
        if ($services->isEmpty() || $requests->isEmpty()) {
            return;
        }

        foreach ($requests as $request) {

            // Avoid adding duplicate sample items
            if ($request->items()->exists()) {
                continue;
            }

            // Select 1 to 3 different services
            $selectedServices = $services
                ->shuffle()
                ->take(min(3, $services->count()));

            foreach ($selectedServices as $service) {

                // Choose a suitable sample quantity
                $quantity = match ($service->pricing_type) {
                    'per_kg' => rand(1, 5),
                    'per_piece' => rand(1, 3),
                    'per_pair' => rand(1, 2),
                    'fixed' => 1,
                    default => 1,
                };

                $unitPrice = $service->price;
                $subtotal = $quantity * $unitPrice;

                $request->items()->create([
                    'service_id' => $service->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);
            }

            // Calculate the request's total
            $request->update([
                'total_amount' => $request->items()->sum('subtotal'),
            ]);
        }
    }
}

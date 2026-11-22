<?php

namespace App\Http\Controllers;

use App\Models\LaundryRequest;
use App\Models\RequestItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestItemController extends Controller
{
    // Display all items belonging to a request
    public function index(LaundryRequest $laundryRequest)
    {
        // Ensure customer owns this request
        abort_unless(
            $laundryRequest->customer_id === auth()->id(),
            403
        );

        $laundryRequest->load('items.service');
         $services = Service::where('status', 'active')->get();

        return view(
            'customer.requests.items.index',
            compact('laundryRequest')
        );
    }

    // Display one item
    public function show(
        LaundryRequest $laundryRequest,
        RequestItem $item
    ) {
        // Check request ownership
        abort_unless(
            $laundryRequest->customer_id === auth()->id(),
            403
        );

        // Check if item belongs to this request
        abort_unless(
            $item->request_id === $laundryRequest->id,
            404
        );

        $item->load('service');

        return view(
            'customer.requests.items.show',
            compact('laundryRequest', 'item')
        );
    }

    // Add a service to an existing request
    public function store(
        Request $request,
        LaundryRequest $laundryRequest
    ) {
        abort_unless(
            $laundryRequest->customer_id === auth()->id(),
            403
        );

        $validated = $request->validate([
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],
            'quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $laundryRequest
        ) {
            // Only allow active services
            $service = Service::where('status', 'active')
                ->findOrFail($validated['service_id']);

            $quantity = $validated['quantity'];
            $unitPrice = $service->price;
            $subtotal = $quantity * $unitPrice;

            // Create request item
            $laundryRequest->items()->create([
                'service_id' => $service->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ]);

            // Recalculate total
            $laundryRequest->update([
                'total_amount' => $laundryRequest
                    ->items()
                    ->sum('subtotal'),
            ]);
        });

        return redirect()
            ->route('customer.requests.show', $laundryRequest)
            ->with('success', 'Service added successfully!');
    }

    // Update an item's quantity
    public function update(
        Request $request,
        LaundryRequest $laundryRequest,
        RequestItem $item
    ) {
        abort_unless(
            $laundryRequest->customer_id === auth()->id(),
            403
        );

        abort_unless(
            $item->request_id === $laundryRequest->id,
            404
        );

        $validated = $request->validate([
            'quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $laundryRequest,
            $item
        ) {
            $quantity = $validated['quantity'];

            $item->update([
                'quantity' => $quantity,
                'subtotal' => $quantity * $item->unit_price,
            ]);

            // Recalculate parent request total
            $laundryRequest->update([
                'total_amount' => $laundryRequest
                    ->items()
                    ->sum('subtotal'),
            ]);
        });

        return redirect()
            ->route('customer.requests.show', $laundryRequest)
            ->with('success', 'Service quantity updated successfully!');
    }

    // Delete an item
    public function destroy(
        LaundryRequest $laundryRequest,
        RequestItem $item
    ) {
        abort_unless(
            $laundryRequest->customer_id === auth()->id(),
            403
        );

        abort_unless(
            $item->request_id === $laundryRequest->id,
            404
        );

        DB::transaction(function () use (
            $laundryRequest,
            $item
        ) {
            $item->delete();

            // Recalculate parent request total
            $laundryRequest->update([
                'total_amount' => $laundryRequest
                    ->items()
                    ->sum('subtotal'),
            ]);
        });

        return redirect()
            ->route('customer.requests.show', $laundryRequest)
            ->with('success', 'Service removed successfully!');
    }
}

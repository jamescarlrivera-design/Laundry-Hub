<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLaundryRequest;
use App\Models\LaundryRequest;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use App\Models\Branch;
use App\Models\PickupInformation;
use App\Http\Requests\UpdateLaundryRequestStatus;

class LaundryRequestController extends Controller
{


    public function staffIndex()
    {
        $branchId = auth()->user()->branch_id;

        $requests = LaundryRequest::with([
            'customer',
            'branch',
            'items.service'
        ])
            ->where('branch_id', $branchId)
            ->latest()
            ->paginate(10);

        return view('staff.requests.index', compact('requests'));
    }


    public function staffShow(LaundryRequest $request)
    {
        $branchIds = auth()->user()
            ->branch()
            ->pluck('branches.id');

        // Prevent staff from viewing requests outside their assigned branches
        abort_unless($branchIds->contains($request->branch_id), 403);

        $request->load([
            'customer',
            'branch',
            'items.service',
            'pickupInformation'
    
        ]);

        return view('staff.requests.show', compact('request'));
    }


    public function staffupdate(Request $request, LaundryRequest $laundryRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,processing,completed,cancelled',
        ]);

        $laundryRequest->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('staff.requests.index')
            ->with('success', 'Request status updated successfully.');
    }











    // Display logged-in customer's requests
    public function customerindex()
    {
        $requests = LaundryRequest::with('customer', 'items.service')
            ->where('customer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.requests.index', compact('requests'));
    }



    // Display one request
    public function customershow(LaundryRequest $laundryRequest)
    {
        // Make sure customer can only view their own request
        abort_unless(
            $laundryRequest->customer_id === auth()->id(),
            403
        );

        $laundryRequest->load('customer', 'items.service');

        return view('customer.requests.show', compact('laundryRequest'));
    }

    public function customerstore(StoreLaundryRequest $request)
    {
        $validated = $request->validated();

        $order = DB::transaction(function () use ($validated) {

            // Get the selected branch
            $branch = Branch::findOrFail($validated['branch_id']);

            // Determine fulfillment fee
            $fulfillmentType = $validated['fulfillment_type'];
            $fulfillmentFee = $fulfillmentType === 'pickup' ? 50 : 0;

            $total = 0;

            // Create parent request
            $order = LaundryRequest::create([
                'customer_id' => auth()->id(),
                'branch_id' => $branch->id,
                'fulfillment_type' => $fulfillmentType,
                'fulfillment_fee' => $fulfillmentFee,
                'pickup_address' => $validated['fulfillment_type'] === 'pickup'
                    ? auth()->user()->address
                    : null,
                'pickup_contact_number' => auth()->user()->contact_number,

                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create request items
            foreach ($validated['items'] as $item) {

                // Get service assigned to this branch
                $service = $branch->services()
                    ->wherePivot('is_active', true)
                    ->where('services.id', $item['service_id'])
                    ->first();

                // Check service availability
                if (!$service) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'items' => 'One or more selected services are unavailable at this branch.',
                    ]);
                }

                // Calculate individual service price
                $unitPrice = (float) $service->pivot->price;
                $quantity = (int) $item['quantity'];
                $subtotal = $unitPrice * $quantity;

                // Save individual service breakdown
                $order->items()->create([
                    'service_id' => $service->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                // Add subtotal to grand total
                $total += $subtotal;
            }

            // Add fulfillment fee
            $total += $fulfillmentFee;

            // Update parent request total
            $order->update([
                'total_amount' => $total,
            ]);

            return $order;
        });

        return redirect()
            ->route('customer.requests.index')
            ->with('success', 'Laundry request submitted successfully!');
    }


    public function customercreate(Request $request)
    {
        $branch = Branch::findOrFail($request->query('branch_id'));

        $services = $branch->services()
            ->wherePivot('is_active', true)
            ->get();

        $selectedService = $request->query('service_id');

          $pickupInformations = auth()->user()
        ->pickupInformation()
        ->get();


  



        return view('customer.requests.create', compact(
            'branch',
            'services',
            'selectedService',
            'pickupInformations'
        ));
    }





    public function branchServices(Branch $branch)
    {
        // Get active services assigned to this branch
        $services = $branch->services()->get();

        return view('customer.branches.services', compact(
            'branch',
            'services'
        ));
    }

}

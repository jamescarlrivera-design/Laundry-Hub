<x-app-layout>

    <div class="max-w-5xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Request Details
                </h1>

                <p class="text-gray-500 mt-2">
                    Request #{{ $request->id }}
                </p>
            </div>

            <a href="{{ route('staff.requests.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                ← Back to Requests
            </a>

        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Customer and Request Information --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

           {{-- Customer Information --}}
<div class="bg-white border rounded-xl shadow-sm p-6">

    <h2 class="text-lg font-bold text-gray-800 mb-5">
        Customer Information
    </h2>

    <div class="space-y-4">

        {{-- Customer Name --}}
        <div>
            <p class="text-sm text-gray-500">Customer Name</p>
            <p class="font-semibold text-gray-800">
                {{ $request->customer->name ?? 'Unknown Customer' }}
            </p>
        </div>

        {{-- Email --}}
        <div>
            <p class="text-sm text-gray-500">Email Address</p>
            <p class="font-medium text-gray-800">
                {{ $request->customer->email ?? 'Not provided' }}
            </p>
        </div>

        {{-- Contact Number --}}
        <div>

            <p class="text-sm text-gray-500">Contact Number</p>
            <p class="font-medium text-gray-800">
                {{ $request->pickupInformation->contact_number ?? 'Not provided' }}
            </p>
        </div>

        {{-- Pickup Address --}}
        <div>
            <p class="text-sm text-gray-500">Pickup Address</p>
            <p class="font-medium text-gray-800">
                {{ $request->pickupInformation->address ?? 'Not provided' }}
            </p>
        </div>

        {{-- Landmark --}}
        <div>
            <p class="text-sm text-gray-500">Landmark</p>
            <p class="font-medium text-gray-800">
                {{ $request->pickupInformation->landmark ?? 'Not provided' }}
            </p>
        </div>

        {{-- Additional Instructions --}}
        <div>
            <p class="text-sm text-gray-500">Additional Instructions</p>
            <p class="font-medium text-gray-800">
                {{ $request->pickupInformation->additional_instructions ?? 'None' }}
            </p>
        </div>

    </div>
</div>

            {{-- Request Information --}}
            <div class="bg-white border rounded-xl shadow-sm p-6">

                <h2 class="text-lg font-bold text-gray-800 mb-5">
                    Request Information
                </h2>

                <div class="space-y-4">

                    <div>
                        <p class="text-sm text-gray-500">Request Number</p>
                        <p class="font-semibold text-gray-800">
                            #{{ $request->id }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Branch</p>
                        <p class="font-medium text-gray-800">
                            {{ $request->branch->name ?? 'No Branch' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Date Submitted</p>
                        <p class="font-medium text-gray-800">
                            {{ $request->created_at->format('F d, Y h:i A') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status</p>

                        <span class="inline-flex px-3 py-1 mt-1 rounded-full text-xs font-semibold
                            @if($request->status === 'pending')
                                bg-yellow-100 text-yellow-700
                            @elseif($request->status === 'approved')
                                bg-blue-100 text-blue-700
                            @elseif($request->status === 'processing')
                                bg-indigo-100 text-indigo-700
                            @elseif($request->status === 'completed')
                                bg-green-100 text-green-700
                            @elseif($request->status === 'cancelled')
                                bg-red-100 text-red-700
                            @else
                                bg-gray-100 text-gray-700
                            @endif">

                            {{ ucfirst($request->status) }}

                        </span>
                    </div>


                </div>


            </div>

        </div>

        {{-- Services Ordered --}}
        <div class="bg-white border rounded-xl shadow-sm overflow-hidden">

            <div class="p-6 border-b">
                <h2 class="text-lg font-bold text-gray-800">
                    Requested Services
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Breakdown of the customer's selected services.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-gray-50 text-gray-500 text-sm">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Service</th>
                            <th class="px-6 py-4 font-semibold text-center">Quantity</th>
                            <th class="px-6 py-4 font-semibold text-right">Unit Price</th>
                            <th class="px-6 py-4 font-semibold text-right">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse($request->items as $item)

                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800">
                                        {{ $item->service->service_name ?? 'Deleted Service' }}
                                    </p>
                                </td>

                                <td class="px-6 py-4 text-center text-gray-700">
                                    {{ $item->quantity }}
                                </td>

                                <td class="px-6 py-4 text-right text-gray-700">
                                    ₱{{ number_format($item->unit_price, 2) }}
                                </td>

                                <td class="px-6 py-4 text-right font-semibold text-gray-800">
                                    ₱{{ number_format($item->subtotal, 2) }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    No services found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            
{{-- Order Summary --}}
<div class="p-6 border-t bg-gray-50">

    @php
        $serviceTotal = $request->items->sum('subtotal');
        $pickupFee = $request->fulfillment_fee ?? 0;
    @endphp

    <h3 class="text-lg font-bold text-gray-800 mb-5">
        Order Summary
    </h3>

    {{-- Service Subtotal --}}
    <div class="flex justify-between items-center mb-3">
        <span class="text-gray-600">
            Services Subtotal
        </span>

        <span class="font-medium text-gray-800">
            ₱{{ number_format($serviceTotal, 2) }}
        </span>
    </div>

    {{-- Fulfillment Method 
    <div class="flex justify-between items-center mb-3">
        <span class="text-gray-600">
            Fulfillment Method
        </span>

        <span class="font-semibold
            {{ $request->fulfillment_type === 'pickup' ? 'text-blue-600' : 'text-green-600' }}">
            {{ $request->fulfillment_type === 'pickup' ? '🚚 Pickup' : '🏪 Walk-in' }}
        </span>
    </div>

    {{-- Pickup Fee 
    <div class="flex justify-between items-center mb-4">
        <span class="text-gray-600">
            {{ $request->fulfillment_type === 'pickup' ? 'Pickup Fee' : 'Fulfillment Fee' }}
        </span>

        <span class="font-medium {{ $pickupFee > 0 ? 'text-blue-600' : 'text-green-600' }}">
            {{ $pickupFee > 0 ? '+' : '' }}₱{{ number_format($pickupFee, 2) }}
        </span>
    </div> 
    

    {{-- Grand Total --}}
    <div class="border-t border-gray-300 pt-4 flex justify-between items-center">

        <span class="font-bold text-gray-800 text-lg">
            Grand Total
        </span>

        <span class="text-3xl font-bold text-blue-700">
            ₱{{ number_format($request->total_amount, 2) }}
        </span>

    </div>

</div>


        </div>

        {{-- Customer Notes --}}
        @if($request->notes)
            <div class="bg-white border rounded-xl shadow-sm p-6 mt-6">

                <h2 class="text-lg font-bold text-gray-800 mb-3">
                    Customer Notes
                </h2>

                <p class="text-gray-600">
                    {{ $request->notes }}
                </p>

            </div>
        @endif



        <div class="pt-4 border-t">

            <form action="{{ route('staff.requests.update-status', $request->id) }}" method="POST">

                @csrf
                @method('PATCH')

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Update Request Status
                </label>

                <select name="status"
                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 mb-3">

                    <option value="pending" @selected($request->status === 'pending')>
                        Pending
                    </option>

                    <option value="approved" @selected($request->status === 'approved')>
                        Approved
                    </option>

                    <option value="processing" @selected($request->status === 'processing')>
                        Processing
                    </option>

                    <option value="completed" @selected($request->status === 'completed')>
                        Completed
                    </option>

                    <option value="cancelled" @selected($request->status === 'cancelled')>
                        Cancelled
                    </option>

                </select>

              

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">
                    Update Status
                </button>

            </form>

        </div>

    </div>

</x-app-layout>
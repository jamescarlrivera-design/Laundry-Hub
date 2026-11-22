
<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Laundry Request Details
                </h1>

                <p class="text-gray-500 mt-1">
                    Request #{{ $laundryRequest->id }}
                </p>
            </div>

            <a href="{{ route('customer.requests.index') }}"
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                Back to Requests
            </a>

        </div>

        {{-- Request Information --}}
        <div class="bg-white shadow rounded-xl p-6 mb-6">

            <h2 class="text-lg font-semibold mb-4">
                Request Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <p class="text-sm text-gray-500">Request ID</p>
                    <p class="font-medium">#{{ $laundryRequest->id }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Customer</p>
                    <p class="font-medium">
                        {{ $laundryRequest->customer->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Date Submitted</p>
                    <p class="font-medium">
                        {{ $laundryRequest->created_at->format('M d, Y h:i A') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Status</p>

                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'approved' => 'bg-green-100 text-green-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'completed' => 'bg-purple-100 text-purple-700',
                            'declined' => 'bg-red-100 text-red-700',
                        ];

                        $status = strtolower($laundryRequest->status);
                    @endphp

                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($laundryRequest->status) }}
                    </span>
                </div>

            </div>

        </div>

        {{-- Selected Services --}}
        <div class="bg-white shadow rounded-xl p-6">

            <h2 class="text-lg font-semibold mb-4">
                Selected Laundry Services
            </h2>

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead>
                        <tr class="bg-gray-100 text-gray-600">
                            <th class="p-3">Service</th>
                            <th class="p-3">Quantity</th>
                            <th class="p-3">Unit Price</th>
                            <th class="p-3">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($laundryRequest->items as $item)

                            <tr class="border-b">

                                <td class="p-3 font-medium">
                                    {{ $item->service->name }}
                                </td>

                                <td class="p-3">
                                    {{ $item->quantity }}
                                </td>

                                <td class="p-3">
                                    ₱{{ number_format($item->unit_price, 2) }}
                                </td>

                                <td class="p-3">
                                    ₱{{ number_format($item->subtotal, 2) }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- Total --}}
            <div class="flex justify-end mt-6">

                <div class="text-right">

                    <p class="text-gray-500">
                        Total Amount
                    </p>

                    <p class="text-2xl font-bold text-gray-800">
                        ₱{{ number_format($laundryRequest->total_amount, 2) }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>

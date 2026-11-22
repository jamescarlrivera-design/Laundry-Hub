
<x-app-layout>

    <div class="max-w-6xl mx-auto p-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Request Items
                </h1>

                <p class="text-gray-500">
                    Laundry Request #{{ $laundryRequest->id }}
                </p>
            </div>

            <a href="{{ route('customer.requests.show', $laundryRequest) }}"
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                Back to Request
            </a>

        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Request Items Table --}}
        <div class="bg-white shadow rounded-xl p-6">

            <h2 class="text-lg font-semibold mb-4">
                Selected Services
            </h2>

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead>
                        <tr class="bg-gray-100 text-gray-600">
                            <th class="p-3">Service</th>
                            <th class="p-3">Quantity</th>
                            <th class="p-3">Unit Price</th>
                            <th class="p-3">Subtotal</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($laundryRequest->items as $item)

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

                                <td class="p-3">
                                    <a href="{{ route('customer.requests.items.show', [$laundryRequest, $item]) }}"
                                       class="text-blue-600 hover:underline">
                                        View
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">
                                    No services found for this request.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Total Amount --}}
            <div class="flex justify-end mt-6">

                <div class="text-right">
                    <p class="text-gray-500">
                        Total Amount
                    </p>

                    <p class="text-2xl font-bold">
                        ₱{{ number_format($laundryRequest->total_amount, 2) }}
                    </p>
                </div>

            </div>

        </div>

    </div>

</x-app-layout>

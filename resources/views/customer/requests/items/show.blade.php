
<x-app-layout>

    <div class="max-w-4xl mx-auto p-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Service Details
                </h1>

                <p class="text-gray-500">
                    Request #{{ $laundryRequest->id }}
                </p>
            </div>

            <a href="{{ route('customer.requests.items.index', $laundryRequest) }}"
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                Back to Items
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

        {{-- Service Information --}}
        <div class="bg-white shadow rounded-xl p-6 mb-6">

            <h2 class="text-lg font-semibold mb-5">
                Service Information
            </h2>

            <div class="space-y-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Service Name
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ $item->service->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Unit Price
                    </p>

                    <p class="font-medium">
                        ₱{{ number_format($item->unit_price, 2) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Current Quantity
                    </p>

                    <p class="font-medium">
                        {{ $item->quantity }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Subtotal
                    </p>

                    <p class="text-xl font-bold text-gray-800">
                        ₱{{ number_format($item->subtotal, 2) }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Update Quantity --}}
        <div class="bg-white shadow rounded-xl p-6 mb-6">

            <h2 class="text-lg font-semibold mb-4">
                Update Quantity
            </h2>

            <form action="{{ route('customer.requests.items.update', [$laundryRequest, $item]) }}"
                  method="POST">

                @csrf
                @method('PATCH')

                <div class="mb-4">

                    <label class="block text-sm font-medium mb-2">
                        New Quantity
                    </label>

                    <input
                        type="number"
                        name="quantity"
                        value="{{ old('quantity', $item->quantity) }}"
                        min="0.01"
                        step="0.01"
                        required
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                    >

                </div>

                <button type="submit"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    Update Quantity
                </button>

            </form>

        </div>

        {{-- Delete Item --}}
        <div class="bg-white shadow rounded-xl p-6">

            <h2 class="text-lg font-semibold text-red-600 mb-2">
                Remove Service
            </h2>

            <p class="text-gray-500 mb-4">
                Are you sure you want to remove this service from your laundry request?
            </p>

            <form action="{{ route('customer.requests.items.destroy', [$laundryRequest, $item]) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to remove this service?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                    Remove Service
                </button>

            </form>

        </div>

    </div>

</x-app-layout>

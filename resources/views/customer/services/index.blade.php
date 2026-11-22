
<x-app-layout>

    <div class="max-w-4xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Our Laundry Services
                </h1>

                <p class="text-gray-500 mt-2">
                    Choose from our available laundry services.
                </p>
            </div>

            @if(auth()->user()->role === 'customer')
                <a href="{{ route('customer.branches.index') }}"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                    Request Service
                </a>
            @endif
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Services List --}}
        <div class="space-y-4">

            @forelse($services as $service)

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition p-5">

                    <div class="flex items-center gap-5">

                        {{-- Service Icon --}}
                        <div class="w-14 h-14 shrink-0 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-7 h-7 text-blue-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 7h18M5 7l1 13h12l1-13M9 7V4h6v3M9 11v5m6-5v5" />
                            </svg>
                        </div>

                        {{-- Service Information --}}
                        <div class="flex-grow min-w-0">

                            <h2 class="text-lg font-bold text-gray-800">
                                {{ $service->service_name }}
                            </h2>

                            <p class="text-gray-500 text-sm mt-1">
                                {{ $service->description ?? 'Professional laundry service for your convenience.' }}
                            </p>

                        </div>

                        {{-- Price --}}
                        <div class="text-right shrink-0">
                            <p class="text-xs text-gray-500">
                                Starting at
                            </p>

                            <p class="text-xl font-bold text-blue-600">
                                ₱{{ number_format($service->price, 2) }}
                            </p>
                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-xl border p-10 text-center">
                    <h2 class="text-lg font-semibold text-gray-700">
                        No Services Available
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Please check back later for available laundry services.
                    </p>
                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $services->links() }}
        </div>

    </div>

</x-app-layout>

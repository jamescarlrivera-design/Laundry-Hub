<x-app-layout>

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Branch Information --}}
        <div class="mb-8">
            <a href="{{ route('customer.branches.index') }}" class="text-blue-600 hover:underline">
                ← Back to Branches
            </a>

            <h1 class="text-3xl font-bold mt-4">
                {{ $branch->name }}
            </h1>

            <p class="text-gray-500">
                {{ $branch->address }}
            </p>

            <h2 class="text-xl font-semibold mt-6">
                Available Laundry Services
            </h2>
        </div>


        {{-- Services Grid --}}
        @if($services->isEmpty())

            <div class="bg-yellow-50 text-yellow-700 p-6 rounded-xl">
                No services have been assigned to this branch yet.
            </div>

        @else

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                @foreach($services as $service)

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200
                                hover:shadow-lg hover:-translate-y-1 transition duration-300
                                overflow-hidden">

                        {{-- Card Header --}}
                        <div class="p-6">

                            <div class="flex justify-between items-start gap-3">

                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">
                                        {{ $service->service_name }}
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-2">
                                        {{ $service->description }}
                                    </p>
                                </div>

                                {{-- Status --}}
                                @if($service->pivot->is_active)
                                    <span class="px-3 py-1 text-xs font-semibold
                                                     bg-green-100 text-green-700 rounded-full whitespace-nowrap">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold
                                                     bg-red-100 text-red-700 rounded-full whitespace-nowrap">
                                        Inactive
                                    </span>
                                @endif

                            </div>

                            {{-- Price --}}
                            <div class="mt-6 pt-4 border-t border-gray-100">

                                <p class="text-sm text-gray-500">
                                    Service Price
                                </p>

                                <div class="flex items-baseline gap-1 mt-1">

                                    <span class="text-3xl font-bold text-blue-600">
                                        ₱{{ number_format($service->pivot->price, 2) }}
                                    </span>

                                    <span class="text-sm text-gray-500">
                                        / {{ $service->pivot->unit }}
                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- Card Footer --}}
                        <div class="px-6 pb-6">

                            @if($service->pivot->is_active)

                                        <a href="{{ route('customer.requests.create', [
                                    'branch_id' => $branch->id,
                                    'service_id' => $service->id
                                ]) }}" class="block w-full text-center bg-blue-600
                                                      hover:bg-blue-700 text-white font-semibold
                                                      py-3 rounded-xl transition">

                                            Select Service

                                        </a>

                            @else

                                <button disabled class="w-full bg-gray-100 text-gray-400
                                                   font-semibold py-3 rounded-xl cursor-not-allowed">

                                    Currently Unavailable

                                </button>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @endif


    </div>

</x-app-layout>
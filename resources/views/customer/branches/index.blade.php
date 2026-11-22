<x-app-layout>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Heading --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800">
                    Choose a Laundry Branch
                </h2>

                <p class="text-gray-500 mt-2">
                    Select your preferred LaundryHub branch to continue your laundry request.
                </p>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-5">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Branch Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($branches as $branch)

                            <div
                                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">

                                {{-- Card Header --}}
                                <div class="bg-blue-600 p-5 text-white">
                                    <div class="flex justify-between items-start">

                                        <div>
                                            <h3 class="text-xl font-bold">
                                                {{ $branch->name }}
                                            </h3>

                                            <p class="text-blue-100 text-sm mt-1">
                                                {{ $branch->branch_code }}
                                            </p>
                                        </div>

                                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs">
                                            Active
                                        </span>

                                    </div>
                                </div>

                                {{-- Card Body --}}
                                <div class="p-5 space-y-4">

                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-semibold">
                                            Address
                                        </p>

                                        <p class="text-gray-700 text-sm mt-1">
                                            {{ $branch->address }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-semibold">
                                            Contact Number
                                        </p>

                                        <p class="text-gray-700 text-sm mt-1">
                                            {{ $branch->phone ?? 'Not available' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-semibold">
                                            Email
                                        </p>

                                        <p class="text-gray-700 text-sm mt-1">
                                            {{ $branch->email ?? 'Not available' }}
                                        </p>
                                    </div>

                                    {{-- Select Branch --}}
                                    <div class="pt-3">
                                        <a href="{{ route('customer.branches.services', $branch->id) }}" class="inline-flex items-center justify-center w-full px-4 py-2
                      bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                            Select Branch
                                        </a>
                                    </div>

                                </div>
                            </div>

                @empty

                    <div class="col-span-full bg-white rounded-xl p-10 text-center border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-700">
                            No Available Branches
                        </h3>

                        <p class="text-gray-500 mt-2">
                            There are currently no active branches available.
                        </p>
                    </div>

                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $branches->links() }}
            </div>

        </div>
    </div>

</x-app-layout>

<x-app-layout>

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Staff Dashboard
            </h1>

            <p class="text-gray-500 mt-2">
                Welcome back, {{ auth()->user()->name }}!
                Manage your branch's laundry operations here.
            </p>
        </div>

        {{-- Assigned Branches --}}
        <div class="mb-8">

            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        My Assigned Branches
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Your currently assigned laundry locations.
                    </p>
                </div>

                <span class="text-sm font-semibold text-blue-700 bg-blue-50 px-3 py-1.5 rounded-full">
                    {{ auth()->user()->branch ? 1 : 0 }} Branch Assigned
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @forelse([auth()->user()->branch] as $branch)

                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">

                        <div class="flex items-center justify-between mb-5">

                            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/>
                                </svg>
                            </div>

                            <span class="text-xs font-semibold text-green-700 bg-green-50 px-3 py-1 rounded-full">
                                Assigned
                            </span>

                        </div>

                        <h3 class="text-lg font-bold text-gray-800">
                            {{ $branch->name }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $branch->address ?? 'LaundryHub Branch' }}
                        </p>

                        <div class="border-t border-gray-100 mt-5 pt-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">
                                Branch Assignment
                            </p>
                            <p class="text-sm font-medium text-gray-700 mt-1">
                                Staff Member
                            </p>
                        </div>

                    </div>

                @empty

                    <div class="col-span-full bg-gray-50 border border-dashed border-gray-300 rounded-xl p-8 text-center">
                        <p class="font-semibold text-gray-700">
                            No branches assigned
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            Contact your administrator for branch assignment.
                        </p>
                    </div>

                @endforelse

            </div>
        </div>

        {{-- Dashboard Statistics --}}
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
            {{-- Pending Requests --}}
            <div class="bg-white border rounded-xl shadow-sm p-6">
                
                
                
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Pending Requests</p>
                        <h2 class="text-3xl font-bold text-yellow-600 mt-2">
                            {{ $totalRequests ?? 0 }}
                        </h2>
                    </div>

                    <div class="bg-yellow-100 p-3 rounded-xl">
                        <svg class="w-7 h-7 text-yellow-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
           
            {{-- Processing Requests --}}
            <div class="bg-white border rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Processing</p>
                        <h2 class="text-3xl font-bold text-blue-600 mt-2">
                            {{ $processingRequests ?? 0 }}
                        </h2>
                    </div>

                    <div class="bg-blue-100 p-3 rounded-xl">
                        <svg class="w-7 h-7 text-blue-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Completed Requests --}}
            <div class="bg-white border rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Completed</p>
                        <h2 class="text-3xl font-bold text-green-600 mt-2">
                            {{ $completedRequests ?? 0 }}
                        </h2>
                    </div>

                    <div class="bg-green-100 p-3 rounded-xl">
                        <svg class="w-7 h-7 text-green-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        {{-- Quick Actions --}}
        <div class="bg-white border rounded-xl shadow-sm p-6">

            <h2 class="text-xl font-bold text-gray-800 mb-5">
                Quick Actions
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <a href="{{ route('staff.requests.index') }}"
                    class="flex items-center justify-between p-4 border rounded-lg hover:bg-blue-50 hover:border-blue-300 transition">

                    <div>
                        <h3 class="font-semibold text-gray-800">
                            Manage Laundry Requests
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            View and update customer requests.
                        </p>
                    </div>

                    <span class="text-blue-600 text-xl">→</span>
                </a>

                <a href="{{ route('staff.requests.index', ['status' => 'processing']) }}"
                    class="flex items-center justify-between p-4 border rounded-lg hover:bg-blue-50 hover:border-blue-300 transition">

                    <div>
                        <h3 class="font-semibold text-gray-800">
                            View Processing Orders
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Check laundry currently being processed.
                        </p>
                    </div>

                    <span class="text-blue-600 text-xl">→</span>
                </a>

            </div>

        </div>

    </div>

</x-app-layout>

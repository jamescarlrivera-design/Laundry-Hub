 
<x-app-layout>

    <div class="max-w-7xl mx-auto p-6">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Laundry Requests
                </h1>
                <p class="text-gray-500 text-sm mt-1">
                    Manage laundry requests for your assigned branch.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">

            <div class="p-4 border-b">
                <h2 class="font-semibold text-gray-700">
                    All Branch Requests
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">

                    <thead class="bg-gray-100 text-gray-600 uppercase">
                        <tr>
                            <th class="p-4">Request ID</th>
                            <th class="p-4">Customer</th>
                            <th class="p-4">Total Amount</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Date Requested</th>
                            <th class="p-4 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse($requests as $request)

                            <tr class="hover:bg-gray-50">

                                <td class="p-4 font-medium text-gray-800">
                                    #{{ $request->id }}
                                </td>

                                <td class="p-4">
                                    {{ $request->customer->name ?? 'Unknown Customer' }}
                                </td>

                                <td class="p-4 font-semibold">
                                    ₱{{ number_format($request->total_amount, 2) }}
                                </td>

                                <td class="p-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'approved' => 'bg-blue-100 text-blue-700',
                                            'processing' => 'bg-indigo-100 text-indigo-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>

                                <td class="p-4 text-gray-500">
                                    {{ $request->created_at->format('M d, Y h:i A') }}
                                </td>

                                <td class="p-4 text-center">
                                    <a href="{{ route('staff.requests.show', $request->id) }}"
                                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-semibold">
                                        View Details
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-500">
                                    No laundry requests found for your branch.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            <div class="p-4 border-t">
                {{ $requests->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
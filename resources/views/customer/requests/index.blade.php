
<x-app-layout>

    <div class="max-w-7xl mx-auto p-6">

        <h1 class="text-2xl font-bold mb-6">
            My Laundry Requests
        </h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3">Request ID</th>
                    <th class="p-3">Total Amount</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($requests as $request)
                    <tr class="border-t">
                        <td class="p-3">
                            #{{ $request->id }}
                        </td>

                        <td class="p-3">
                            ₱{{ number_format($request->total_amount, 2) }}
                        </td>

                        <td class="p-3">
                            {{ ucfirst($request->status) }}
                        </td>

                        <td class="p-3">
                            <a href="{{ route('customer.requests.show', $request) }}"
                               class="text-blue-600">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center">
                            You haven't submitted any laundry requests.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $requests->links() }}
        </div>

    </div>

</x-app-layout>

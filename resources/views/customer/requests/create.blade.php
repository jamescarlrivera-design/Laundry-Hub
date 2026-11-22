
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Create Laundry Request
        </h2>
    </x-slot>

    

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    <strong>Please fix the following errors:</strong>
                    <ul class="list-disc ml-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl p-6">

                <h3 class="text-2xl font-bold text-gray-800 mb-2">
                    Request Laundry Services
                </h3>

                <p class="text-gray-500 mb-6">
                    Choose your services and specify the quantity for each.
                </p>

              
    </div>


                   

                <form action="{{ route('customer.requests.store') }}"
                      method="POST">
                    @csrf

                    {{-- Selected Branch --}}
                    <div class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-5">

                        <p class="text-sm text-blue-600 font-semibold mb-1">
                            SELECTED BRANCH
                        </p>

                        <h4 class="text-xl font-bold text-gray-800">
                            {{ $branch->name }}
                        </h4>

                        <p class="text-sm text-gray-600 mt-1">
                            {{ $branch->address }}
                        </p>

                        <input type="hidden"
                               name="branch_id"
                               value="{{ $branch->id }}">
                    </div>

                    {{-- Request Items --}}
                    <div class="mb-8">

                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h4 class="font-bold text-gray-800 text-lg">
                                    Requested Services
                                </h4>

                                <p class="text-sm text-gray-500">
                                    Add one or more services to your request.
                                </p>
                            </div>

                            <button type="button"
                                    id="add-item"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                + Add Service
                            </button>
                        </div>

                        <div id="request-items" class="space-y-4">

                            {{-- First Request Item --}}
                            <div class="request-item border border-gray-200 rounded-lg p-4">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    {{-- Service --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Select Service
                                        </label>

                                        <select name="items[0][service_id]"
                                                required
                                                class="service-select w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                                            <option value="">Choose a service</option>

                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}"
                                                        data-price="{{ $service->pivot->price }}"
                                                        data-unit="{{ $service->pivot->unit }}"
                                                    {{ old('items.0.service_id', $selectedService) == $service->id ? 'selected' : '' }}>

                                                    {{ $service->service_name }}
                                                    - ₱{{ number_format($service->pivot->price, 2) }}/{{ $service->pivot->unit }}

                                                </option>
                                            @endforeach

                                        </select>

                                        @error('items.0.service_id')
                                            <p class="text-red-500 text-sm mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Quantity --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Quantity
                                        </label>

                                        <input type="number"
                                               name="items[0][quantity]"
                                               value="{{ old('items.0.quantity', 1) }}"
                                               min="1"
                                               max="999"
                                               step="1"
                                               required
                                               class="quantity-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                                        @error('items.0.quantity')
                                            <p class="text-red-500 text-sm mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                </div>

                                {{-- Item Price Breakdown --}}
                                <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between text-sm text-gray-500">
                                        <span>Price per unit</span>
                                        <span class="unit-price">₱0.00</span>
                                    </div>

                                    <div class="flex justify-between text-sm text-gray-500 mt-2">
                                        <span>Quantity</span>
                                        <span class="item-quantity">1</span>
                                    </div>

                                    <div class="flex justify-between font-bold text-gray-800 border-t mt-3 pt-3">
                                        <span>Subtotal</span>
                                        <span class="item-subtotal text-blue-600">₱0.00</span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    {{-- Request Item Template --}}
                    <template id="item-template">

                        <div class="request-item border border-gray-200 rounded-lg p-4">

                            <div class="flex justify-between items-center mb-3">
                                <h5 class="font-semibold text-gray-700">
                                    Additional Service
                                </h5>

                                <button type="button"
                                        class="remove-item text-red-600 hover:text-red-800 text-sm font-semibold">
                                    Remove
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                {{-- Service --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Select Service
                                    </label>

                                    <select name="items[__INDEX__][service_id]"
                                            required
                                            class="service-select w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                                        <option value="">Choose a service</option>

                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}"
                                                    data-price="{{ $service->pivot->price }}"
                                                    data-unit="{{ $service->pivot->unit }}">
                                                {{ $service->service_name }}
                                                - ₱{{ number_format($service->pivot->price, 2) }}/{{ $service->pivot->unit }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                {{-- Quantity --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Quantity
                                    </label>

                                    <input type="number"
                                           name="items[__INDEX__][quantity]"
                                           value="1"
                                           min="1"
                                           max="999"
                                           step="1"
                                           required
                                           class="quantity-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>

                            </div>





                            

                            {{-- Item Price Breakdown --}}
                            <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between text-sm text-gray-500">
                                    <span>Price per unit</span>
                                    <span class="unit-price">₱0.00</span>
                                </div>

                                <div class="flex justify-between text-sm text-gray-500 mt-2">
                                    <span>Quantity</span>
                                    <span class="item-quantity">1</span>
                                </div>

                                <div class="flex justify-between font-bold text-gray-800 border-t mt-3 pt-3">
                                    <span>Subtotal</span>
                                    <span class="item-subtotal text-blue-600">₱0.00</span>
                                </div>
                            </div>

                        </div>

                    </template>


                    

{{-- Fulfillment Method --}}
<div class="mb-8">
    <h4 class="font-bold text-gray-800 text-lg mb-2">
        Choose Fulfillment Method
    </h4>

    <p class="text-sm text-gray-500 mb-4">
        Choose how you want to submit your laundry.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Pickup --}}
        <label class="cursor-pointer">
            <input type="radio"
                   name="fulfillment_type"
                   value="pickup"
                   data-fee="50"
                   class="fulfillment-radio peer sr-only"
                   {{ old('fulfillment_type', 'walk_in') == 'pickup' ? 'checked' : '' }}
                   required>

            <div class="border-2 border-gray-200 rounded-xl p-5
                        peer-checked:border-blue-600
                        peer-checked:bg-blue-50
                        hover:border-blue-300 transition">

                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🚚</span>

                        <div>
                            <h5 class="font-bold text-gray-800">
                                Pickup
                            </h5>

                            <p class="text-sm text-gray-500">
                                We pick up your laundry.
                            </p>
                        </div>
                    </div>

                    <span class="font-bold text-blue-600">
                        ₱50.00
                    </span>
                </div>

                <p class="text-xs text-gray-500 mt-3">
                    Additional pickup fee applies.
                </p>
            </div>
        </label>


             





        {{-- Walk-in --}}
        <label class="cursor-pointer">
            <input type="radio"
                   name="fulfillment_type"
                   value="walk_in"
                   data-fee="0"
                   class="fulfillment-radio peer sr-only"
                   {{ old('fulfillment_type', 'walk_in') == 'walk_in' ? 'checked' : '' }}>

            <div class="border-2 border-gray-200 rounded-xl p-5
                        peer-checked:border-blue-600
                        peer-checked:bg-blue-50
                        hover:border-blue-300 transition">

                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🏪</span>

                        <div>
                            <h5 class="font-bold text-gray-800">
                                Walk-in
                            </h5>

                            <p class="text-sm text-gray-500">
                                Bring laundry to the branch.
                            </p>
                        </div>
                    </div>

                    <span class="font-bold text-green-600">
                        FREE
                    </span>
                </div>

                <p class="text-xs text-gray-500 mt-3">
                    No additional fulfillment fee.
                </p>
            </div>
        </label>

    </div>

    @error('fulfillment_type')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>




{{-- Pickup Information --}}
<div id="pickupInformationSection"
    class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6">

    <h3 class="text-lg font-bold text-gray-800 mb-4">
        Pickup Information
    </h3>

    <div class="mb-4">
        <label for="pickup_information_id"
            class="block text-sm font-medium text-gray-700 mb-2">
            Select Pickup Address
        </label>

        <select name="pickup_information_id"
            id="pickup_information_id"
            class="w-full rounded-lg border-gray-300">

            <option value="">-- Select Pickup Address --</option>

            @foreach ($pickupInformations as $pickup)
                <option
                    value="{{ $pickup->id }}"
                    data-contact="{{ $pickup->contact_number }}"
                    data-landmark="{{ $pickup->landmark }}"
                    data-instructions="{{ $pickup->additional_instructions }}"
                    {{ old('pickup_information_id') == $pickup->id ? 'selected' : '' }}>
                    {{ $pickup->address }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Contact Number
        </label>
        <input type="text" id="contact_number" readonly
            class="w-full rounded-lg border-gray-300 bg-gray-100">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Landmark
        </label>
        <input type="text" id="landmark" readonly
            class="w-full rounded-lg border-gray-300 bg-gray-100">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Additional Instructions
        </label>
        <textarea id="additional_instructions" readonly
            class="w-full rounded-lg border-gray-300 bg-gray-100"></textarea>
    </div>

</div>




<script>
document.addEventListener('DOMContentLoaded', function () {

    // Pickup Information Elements
    const pickupSelect = document.getElementById('pickup_information_id');
    const contactNumber = document.getElementById('contact_number');
    const landmark = document.getElementById('landmark');
    const instructions = document.getElementById('additional_instructions');

    // Fulfillment Elements
    const fulfillmentRadios = document.querySelectorAll('.fulfillment-radio');
    const pickupSection = document.getElementById('pickupInformationSection');

    // Update pickup details when address changes
    function updatePickupInformation() {

        const selectedOption = pickupSelect.options[pickupSelect.selectedIndex];

        contactNumber.value = selectedOption.dataset.contact || '';
        landmark.value = selectedOption.dataset.landmark || '';
        instructions.value = selectedOption.dataset.instructions || '';
    }

    // Show or hide pickup information
    function togglePickupInformation() {

        const selected = document.querySelector('.fulfillment-radio:checked');

        if (!selected) return;

        if (selected.value === 'pickup') {

            pickupSection.style.display = 'block';
            pickupSelect.required = true;

        } else {

            pickupSection.style.display = 'none';
            pickupSelect.required = false;
        }
    }

    // Listen for address selection
    pickupSelect.addEventListener('change', updatePickupInformation);

    // Listen for fulfillment selection
    fulfillmentRadios.forEach(function (radio) {
        radio.addEventListener('change', togglePickupInformation);
    });

    // Initial page setup
    updatePickupInformation();
    togglePickupInformation();

});
</script>





                    

                    {{-- Grand Total --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-8">

                        <h4 class="font-bold text-gray-800 text-lg mb-4">
                            Order Summary
                        </h4>

                        <div class="flex justify-between text-gray-600 mb-2">
                            <span>Total Services</span>
                            <span id="total-services">0</span>
                        </div>
                        {{-- Fulfillment Fee --}}
<div class="flex justify-between text-gray-600 mb-3">
    <span>Fulfillment Fee</span>
    <span id="fulfillment-fee">₱0.00</span>
</div>

                        <div class="flex justify-between text-gray-600 mb-3">
                            <span>Total Quantity</span>
                            <span id="total-quantity">0</span>
                        </div>

                        <div class="border-t border-blue-200 pt-4 flex justify-between items-center">
                            <span class="font-bold text-gray-800 text-lg">
                                Grand Total
                            </span>

                            <span id="grand-total"
                                  class="text-3xl font-bold text-blue-700">
                                ₱0.00
                            </span>
                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 border-t pt-5">

                        <a href="{{ route('customer.branches.index') }}"
                           class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                            Back
                        </a>

                        <button type="submit"
                                class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold">
                            Submit Request
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Price Calculation and Dynamic Items --}}
    <script>
        let itemIndex = 1;

        const addButton = document.getElementById('add-item');
        const itemsContainer = document.getElementById('request-items');
        const itemTemplate = document.getElementById('item-template');

        const formatter = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2
        });

        function calculateTotal() {

            let grandTotal = 0;
            let totalServices = 0;
            let totalQuantity = 0;

            document.querySelectorAll('.request-item').forEach(item => {

                const serviceSelect = item.querySelector('.service-select');
                const quantityInput = item.querySelector('.quantity-input');

                const selectedOption = serviceSelect.selectedOptions[0];

                const price = selectedOption
                    ? parseFloat(selectedOption.dataset.price) || 0
                    : 0;

                const quantity = Math.max(
                    0,
                    parseInt(quantityInput.value) || 0
                );

                const subtotal = price * quantity;

                item.querySelector('.unit-price').textContent =
                    formatter.format(price);

                item.querySelector('.item-quantity').textContent =
                    quantity;

                item.querySelector('.item-subtotal').textContent =
                    formatter.format(subtotal);

                if (serviceSelect.value) {
                    totalServices++;
                    totalQuantity += quantity;
                    grandTotal += subtotal;
                }

            });


                // Get selected fulfillment method
    const selectedFulfillment = document.querySelector(
        'input[name="fulfillment_type"]:checked'
    );

    const fulfillmentFee = selectedFulfillment
        ? parseFloat(selectedFulfillment.dataset.fee) || 0
        : 0;

    // Add fulfillment fee
    grandTotal += fulfillmentFee;

            document.getElementById('total-services').textContent =
                totalServices;

            document.getElementById('total-quantity').textContent =
                totalQuantity;
            
            document.getElementById('fulfillment-fee').textContent =
        formatter.format(fulfillmentFee);

            document.getElementById('grand-total').textContent =
                formatter.format(grandTotal);

            
        }

        // Add another service
        addButton.addEventListener('click', function () {

            let html = itemTemplate.innerHTML.replaceAll(
                '__INDEX__',
                itemIndex
            );

            itemsContainer.insertAdjacentHTML('beforeend', html);

            itemIndex++;

            calculateTotal();
        });

        // Remove service
        itemsContainer.addEventListener('click', function (event) {

            if (event.target.classList.contains('remove-item')) {

                event.target.closest('.request-item').remove();

                calculateTotal();
            }

        });

        // Recalculate whenever service or quantity changes
        itemsContainer.addEventListener('change', function (event) {

            if (
                event.target.classList.contains('service-select') ||
                event.target.classList.contains('quantity-input')
            ) {
                calculateTotal();
            }

        });

        itemsContainer.addEventListener('input', function (event) {

            if (event.target.classList.contains('quantity-input')) {
                calculateTotal();
            }

        });

        // Recalculate when fulfillment method changes
        document.querySelectorAll('.fulfillment-radio').forEach(radio => {

    radio.addEventListener('change', function () {
        calculateTotal();
    });

        });

        // Initial calculation
        calculateTotal();







</script>




</x-app-layout>

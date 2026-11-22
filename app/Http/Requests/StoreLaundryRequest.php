<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreLaundryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized
     * to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [

            // Customer must select at least one service
            'items' => [
                'required',
                'array',
                'min:1',
            ],

            // Every selected service must exist
            'items.*.service_id' => [
                'required',
                'integer',
                'exists:services,id',
                'distinct',
            ],

            // Quantity must be greater than zero
            'items.*.quantity' => [
                'required',
                'numeric',
                'min:1',
            ],
            'branch_id' => [
                'required',
                'integer',
                Rule::exists('branches', 'id')
                    ->where('status', 'active'),
            ],


            'fulfillment_type' => [
                'required',
                'in:pickup,walk_in',
            ],

            'notes' => ['nullable', 'string', 'max:1000'],

            'pickup_information_id' => [
                'nullable',
                'required_if:fulfillment_type,pickup',
                Rule::exists('pickup_information', 'id')
                    ->where('user_id', auth()->id()),
            ],

        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'items.required' =>
                'Please select at least one service.',

            'items.min' =>
                'Your order must contain at least one service.',

            'items.*.service_id.required' =>
                'Please select a service.',

            'items.*.service_id.exists' =>
                'The selected service does not exist.',

            'items.*.service_id.distinct' =>
                'You cannot select the same service more than once.',

            'items.*.quantity.required' =>
                'Please enter the service quantity.',

            'items.*.quantity.numeric' =>
                'Quantity must be a number.',

            'items.*.quantity.min' =>
                'Quantity must be greater than zero.',

        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'items' => 'laundry services',
            'items.*.service_id' => 'service',
            'items.*.quantity' => 'quantity',
        ];
    }
}

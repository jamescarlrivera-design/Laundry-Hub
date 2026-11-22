<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLaundryRequestStatus extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                'in:pending,approved,processing,completed,cancelled',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Please select a request status.',
            'status.in' => 'The selected request status is invalid.',
        ];
    }
}

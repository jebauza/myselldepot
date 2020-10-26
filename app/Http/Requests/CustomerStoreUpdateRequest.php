<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $customer_id = $this->route('customer_id') ?? null;
        return [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'document' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customers', 'document')->ignore($customer_id)
            ],
            'phone' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customer_id)
            ],
        ];
    }
}

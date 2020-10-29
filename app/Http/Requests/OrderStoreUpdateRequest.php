<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreUpdateRequest extends FormRequest
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
        $order_id = $this->route('order_id') ?? null;
        return [
            'customer_id' => 'required|integer|exists:customers,id',
            'comments' => 'required|string',
            'total' => 'required|numeric',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|exists:customers,id'
        ];
    }
}

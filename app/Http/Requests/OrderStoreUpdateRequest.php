<?php

namespace App\Http\Requests;

use App\Models\Product;
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
            'products' => 'bail|required|array|min:1',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(empty($validator->errors()->all())){
                $this->checkProductStock($validator);
            }
        });
    }

    public function checkProductStock($validator)
    {
        $productsCollect = collect($this->products);
        $productsDB = Product::whereIn('id', $productsCollect->pluck('id'))->get();
        foreach ($productsDB as $prodDB) {
            $quantity = $productsCollect->firstWhere('id', $prodDB->id)['quantity'];
            if (!$prodDB->hasInStock($quantity)) {
                $validator->errors()->add('msg_error_validator', __("There are no :quantity units of :product in stock", [
                    'product' => $prodDB->name,
                    'quantity' => $quantity
                ]));
                break;
            } elseif ($productsCollect->where('id', $prodDB->id)->count() > 1) {
                $validator->errors()->add('msg_error_validator', __("There is a mistake with the :product", ['product'=>$prodDB->name]));
                break;
            }
        }
    }
}

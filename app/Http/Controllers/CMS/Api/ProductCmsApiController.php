<?php

namespace App\Http\Controllers\CMS\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreUpdateRequest;

class ProductCmsApiController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::name($request->name)->description($request->description)->categoryIds($request->categories)
                            ->with('category')->orderBy('name')->paginate();

        return $products;
    }

    public function store(ProductStoreUpdateRequest $request)
    {
        $new_product = new Product($request->all());
        $new_product->categorie_id = $request->category;
        $new_product->created_by = $request->user()->id;
        $new_product->updated_by = $request->user()->id;
        if($new_product->save()) {
            return response()->json(['msg'=>__('Save successfully'), 'product'=>$new_product], 201);
        }

        return response()->json(['msg_error' => __('Internal Server Error')], 500);
    }

    public function update(ProductStoreUpdateRequest $request, $id)
    {
        if(!$product = Product::find($id)){
            return response()->json(['msg_error' => __('Not found')], 404);
        }

        $product->fill($request->all());
        $product->categorie_id = $request->category;
        $product->updated_by = $request->user()->id;
        if($product->save()) {
            return response()->json(['msg'=>__('Save successfully'), 'product'=>$product], 200);
        }

        return response()->json(['msg_error' => __('Internal Server Error')], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

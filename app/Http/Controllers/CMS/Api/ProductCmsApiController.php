<?php

namespace App\Http\Controllers\CMS\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCmsApiController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::name($request->name)->description($request->description)->categoryIds($request->categories)
                            ->orderBy('name')->paginate();

        return $products;
    }

    public function store(Request $request)
    {
        $new_product = new Product($request->all());
        $new_product->created_by = $request->user()->id;
        $new_product->updated_by = $request->user()->id;
        if($new_product->save()) {
            return response()->json(['msg'=>__('Save successfully'), 'product'=>$new_product], 201);
        }

        return response()->json(['msg_error' => __('Internal Server Error')], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

<?php

namespace App\Http\Controllers\CMS\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerStoreUpdateRequest;

class CustomerCmsApiController extends Controller
{
    public function index()
    {
        //
    }

    public function getAllCustomers()
    {
        return Customer::orderBy('name')->get();
    }

    public function store(CustomerStoreUpdateRequest $request)
    {
        $new_customer = new Customer($request->all());
        $new_customer->created_by = $request->user()->id;
        $new_customer->updated_by = $request->user()->id;
        if($new_customer->save()) {
            return response()->json(['msg'=>__('Save successfully'), 'customer' => $new_customer], 201);
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

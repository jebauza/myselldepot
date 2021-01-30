<?php

namespace App\Http\Controllers\CMS\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerStoreUpdateRequest;

class CustomerCmsApiController extends Controller
{
    /**
     * index
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::name($request->name)
                        ->document($request->document)
                        ->orderBy('name')
                        ->paginate();

        return response()->json($customers, 200);
    }

    /**
     * getAllCustomers
     *
     * @return void
     */
    public function getAllCustomers()
    {
        return Customer::orderBy('name')->get();
    }

    /**
     * store
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
    public function update(CustomerStoreUpdateRequest $request, $id)
    {
        if(!$customer = Customer::find($id)){
            return response()->json(['msg_error' => __('Not found')], 404);
        }

        $customer->fill($request->all());
        $customer->created_by = $request->user()->id;
        $customer->updated_by = $request->user()->id;
        if($customer->save()) {
            return response()->json(['msg'=>__('Save successfully'), 'customer' => $customer], 200);
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

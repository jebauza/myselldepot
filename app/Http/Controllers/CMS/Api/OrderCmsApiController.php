<?php

namespace App\Http\Controllers\CMS\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreUpdateRequest;

class OrderCmsApiController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::customerName($request->name)->customerDocument($request->document)->orderNumber($request->order)
                        ->state($request->state)->orderBy('order_number', 'DESC')->paginate();

        return $orders;
    }

    public function store(OrderStoreUpdateRequest $request)
    {
        dd($request->all());
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

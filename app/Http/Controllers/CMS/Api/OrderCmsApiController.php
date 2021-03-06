<?php

namespace App\Http\Controllers\CMS\Api;

use Carbon\Carbon;
use App\Models\Order;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreUpdateRequest;

class OrderCmsApiController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::customerName($request->name)
                        ->customerDocument($request->document)
                        ->orderNumber($request->order)
                        ->state($request->state)
                        ->with('customer', 'seller', 'products')
                        ->orderBy('order_number', 'DESC')
                        ->paginate();

        return $orders;
    }

    public function store(OrderStoreUpdateRequest $request)
    {
        $order_number = Carbon::today()->format('Ymd').'_'.(Order::whereDate('created_at', Carbon::today())->count() + 1);
        $auth_user = $request->user();

        try {
            DB::beginTransaction();
            $new_order = new Order($request->all());
            $new_order->order_number = $order_number;
            $new_order->user_id = $auth_user->id;
            $new_order->created_by = $auth_user->id;
            $new_order->updated_by = $auth_user->id;
            $new_order->state = 'A';
            $new_order->total = floatval($request->total);
            if($new_order->save()) {

                foreach ($request->products as $prod) {
                    $new_order->products()->attach($prod['id'], [
                        'quantity' => $prod['quantity'],
                        'price' => $prod['price']
                    ]);
                }

                DB::commit();
                return response()->json(['msg'=>__('Save successfully'), 'order'=>$new_order], 201);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['msg_error' => $e->getMessage()], 500);
        }
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

    /**
     * generatePDF
     *
     * @param  mixed $id
     * @return void
     */
    public function generatePDF($id)
    {
        if (!$order = Order::with('customer','seller','products')->find($id)) {
            return response()->json(['msg_error' => __('Not found')], 404);
        }

        $logo = public_path('img/AdminLTELogo.png');

        $pdf = PDF::loadView('reports.order.pdf.orderPDF', ['order' => $order, 'logo' => $logo]);
        return $pdf->download( "$order->order_number.pdf");
    }
}

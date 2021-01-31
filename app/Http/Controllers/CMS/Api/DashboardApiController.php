<?php

namespace App\Http\Controllers\CMS\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardApiController extends Controller
{
    /**
     * getProductRanking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProductSalesRanking(Request $request)
    {
        $subQuery = DB::table('details_orders')
                        ->selectRaw('SUM(quantity)')
                        ->whereColumn('product_id', 'products.id')
                        ->toSql();

        $products = DB::table('products')
                        ->select('products.name')
                        ->selectSub($subQuery, 'quantity_sold')
                        ->orderByDesc('quantity_sold')
                        ->limit(5)
                        ->get();

        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

<?php

namespace App\Models\Pivots;

use App\Events\Order\DetailsOrdersSavedEvent;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DetailsOrdersPivot extends Pivot
{
    protected $table = 'details_orders';

    protected $dispatchesEvents = [
        'created' => DetailsOrdersSavedEvent::class,
    ];

    /**
     * getProduct
     *
     * @return Product
     */
    public function getProduct()
    {
        return Product::find($this->product_id);
    }

    /**
     * getOrder
     *
     * @return Order
     */
    public function getOrder()
    {
        return Order::find($this->order_id);
    }
}

<?php

namespace App\Listeners\Order;

use App\Events\Order\DetailsOrdersSavedEvent;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DetailsOrdersSavedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DetailsOrdersSavedEvent  $event
     * @return void
     */
    public function handle(DetailsOrdersSavedEvent $event)
    {
        $detailsOrdersPivot = $event->detailsOrdersPivot;

        $product = $detailsOrdersPivot->getProduct();
        if ($product) {
            $product->addOrSubtractStock('-', $detailsOrdersPivot->quantity);
        }
    }
}

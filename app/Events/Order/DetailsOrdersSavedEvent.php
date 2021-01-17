<?php

namespace App\Events\Order;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Models\Pivots\DetailsOrdersPivot;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DetailsOrdersSavedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $detailsOrdersPivot;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DetailsOrdersPivot $detailsOrdersPivot)
    {
        $this->detailsOrdersPivot = $detailsOrdersPivot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

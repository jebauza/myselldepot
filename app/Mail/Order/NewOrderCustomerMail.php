<?php

namespace App\Mail\Order;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderCustomerMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->order->fresh('customer','seller','products');

        $logo = asset('img/AdminLTELogo.png');

        $email = $this->subject('Ha registrado un pedido en MySellDepot')
                    ->view('reports.order.pdf.orderPDF')
                    ->with(['order' => $this->order, 'logo' => $logo])
                    ->attach($logo);

        if ($this->order->seller && $this->order->seller->email) {
            $email->from($this->order->seller->email);
        }

        return $email;
    }
}

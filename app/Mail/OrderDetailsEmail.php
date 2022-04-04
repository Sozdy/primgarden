<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDetailsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->from('postmaster@mg.awake.su', "Сады Приморья")
            ->subject("Ваш заказ номер ".$this->order->id." принят!")
            ->view('mails.order.client.html')
            ->text('mails.order.client.text');
    }
}

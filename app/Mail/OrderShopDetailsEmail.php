<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShopDetailsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;

    public function __construct($order, $user)
    {
        $this->order = $order;
        $this->user  = $user;
    }

    public function build()
    {
        return $this->from('postmaster@mg.awake.su', "Сады Приморья")
            ->subject("Заказ №".$this->order->id." оформлен на сайте")
            ->view('mails.order.shop.html', ["order" => $this->order, "user" => $this->user])
            ->text('mails.order.shop.text', ["order" => $this->order, "user" => $this->user]);
    }
}

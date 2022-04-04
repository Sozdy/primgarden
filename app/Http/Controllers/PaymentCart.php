<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentCart extends Controller
{
    private $amount = 0;
    private $cart = array();

    public function AddPosition($name, $itemCode, $quantity, $tax, $price)
    {
        $position = array
        (
            'positionId' => count($this->cart) + 1,
            'name' => $name,
            'quantity' => $quantity,
            'itemCode' => $itemCode,
            'tax' => $tax,
            'itemPrice' => $price
        );

        array_push($this->cart, $position);
        $this->amount = $this->amount + $quantity['value'] * $price;
    }

    public function GetAmount(): int
    {
        return $this->amount;
    }

    public function ToJson()
    {
        $cartItems = array
        (
            'cartItems' => array('items' => $this->cart)
        );

        return json_encode($cartItems, JSON_UNESCAPED_UNICODE);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Payment extends Controller
{
    //const BASE_URI = 'https://3dsec.sberbank.ru/';
    const BASE_URI = 'https://securepayments.sberbank.ru/';

    private $userName;
    private $password;

    function __construct($userName, $password)
    {
        $this->userName = $userName;
        $this->password = $password;
    }

    // Номер заказа в системе магазина, корзина в нужном формате, дальше понятно
    public function Register($orderNumber, $cart, $returnUri, $failUri, $description = '')
    {
        $uri = self::BASE_URI . 'payment/rest/register.do?';

        $args = array
        (
            'userName' => $this->userName,
            'password' => $this->password,
            'orderNumber' => $orderNumber,
            'orderBundle' => $cart->ToJson(),
            'amount' => $cart->GetAmount(),
            'returnUrl' => $returnUri,
            'failUrl' => $failUri,
            'description' => $description
        );

        return $this->MakeRequest($uri, $args);
    }

    public function GetOrderStatus($orderId)
    {
        $uri = self::BASE_URI . 'payment/rest/getOrderStatusExtended.do?';

        $args = array
        (
            'userName' => $this->userName,
            'password' => $this->password,
            'orderId' => $orderId,
        );

        return $this->MakeRequest($uri, $args);
    }

    private function MakeRequest($uri, $args)
    {
        $curl = curl_init($uri . http_build_query($args));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}

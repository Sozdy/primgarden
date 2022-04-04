<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PaymentTax;
use App\Mail\OrderDetailsEmail;
use App\Mail\OrderShopDetailsEmail;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Store;
use App\StoreBalance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getBy1c (Request $request) {
        $orders = [];

        if ($request->get("type") == "all")
            $orders = Order::all();
        else if ($request->get("type") == "new")
            $orders = Order::where("is_synchronized", false)->get();

        return $orders;
    }

    public function setSynchronizedBy1c (Request $request)
    {
        foreach ($request->ids as $item) {
            $order = Order::whereId($item)->first();
            $order->is_synchronized = true;
            $order->save();
        }
    }

    public function order(Request $request) {
        if (Auth::user()) {
            $request->validate([
                'fullName' => 'required|max:255',
                'phone' => 'required|max:255',
                'email' => 'required|max:255',
                'store_id' => 'required|min:36|max:36',
                'pickup' => 'required',
            ]);
        } else {
            $request->validate([
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'phone' => 'required|max:255',
                'email' => 'required|max:255',
                'store_id' => 'required|min:36|max:36',
                'pickup' => 'required',
            ]);
        }

        if (!$request->pickup) $request->validate([ 'deliveryAddress' => 'required|min:5']);

        $exceeded_products = [];

        $totalPrice = 0;

        foreach ($request->products as $cart_product) {
            $product_object = Product::where("id", $cart_product["id"])->first();

            // Подхватываем остатки
            $stock_value = StoreBalance::where("product_id", $product_object->id)
                    ->where("store_id", Store::getCurrentStore()->id)
                    ->first()->value ?? 0;

            // Если остаток меньше, чем указано пользователем
            if ($stock_value < $cart_product["count"])
                array_push($exceeded_products, ["name" => $product_object->name, "value" => $stock_value, "min" => min($product_object->minimal_order_count, max($stock_value, 0))]);

            if (Auth::user()) {
                // Если остаток меньше минимального заказа, и пользователь выкупает не всё
                if ($product_object->minimal_order_count > $stock_value && $cart_product["count"] != $stock_value)
                    array_push($exceeded_products, ["name" => $product_object->name, "value" => $stock_value, "min" => min($product_object->minimal_order_count, max($stock_value, 0))]);

                // Если мы пытаемся купить меньше нормы
                if ($product_object->minimal_order_count > $cart_product["count"] && $stock_value > $cart_product["count"])
                    array_push($exceeded_products, ["name" => $product_object->name, "value" => $stock_value, "min" => min($product_object->minimal_order_count, max($stock_value, 0))]);
            }

            // Если товара не осталось
            if ($stock_value < 1)
                array_push($exceeded_products, ["name" => $product_object->name, "value" => 0, "min" => 0]);

            // Product is not exceeded, OK. Let's check cart summary price

            // Определяем ценник продукта
            $price = Auth::user() ? $product_object->wholesale_price : $product_object->retail_price;

            // Применяем скидки
            if ($product_object->discount_min_order && $cart_product["count"] >= $product_object->discount_min_order)
                $price -= $price * ($product_object->discount_percent_max / 100);
            else if ($product_object->discount_percent)
                $price -= $price * ($product_object->discount_percent / 100);

            // Складываем итоговую стоимость по корзине
            $totalPrice += $cart_product["count"] * number_format($price, 2, '.', "");
        }

        // Если есть проблемы с остатками, выводим ошибку
        if (count($exceeded_products) > 0)
            return response($exceeded_products, 200);

        // Если пользователь не зарегистрирован, и в корзине по итогу более или равно 5000р, применяем скидку
        $isCartStockGot = $totalPrice >= 5000 && !Auth::user();

        $order = new Order();

        $order->first_name          = $request->first_name;
        $order->last_name           = $request->last_name;
        $order->user_id             = Auth::user()->id ?? null;
        $order->contact_person      = $request->fullName;
        $order->phone               = $request->phone;
        $order->email               = $request->email;
        $order->store_id            = $request->store_id;
        $order->delivery_type       = $request->pickup ? "pickup" : "delivery";
        $order->delivery_address    = $request->deliveryAddress;
        $order->delivery_comment    = $request->deliveryComment;
        $order->comment             = $request->comment;
        $order->delivery_method_id  = $request->delivery_method_id;
        $order->is_cart_stock_got   = $isCartStockGot;

        $order->save();

        // Создаем Продукты на момент покупки с указанием тех ценников, что получились со всеми скидками на момент покупки
        foreach ($request->products as $cart_product) {
            $product_object = Product::where("id", $cart_product["id"])->first();

            // Еще разок берем стоимость (TODO?)
            $price = Auth::user() ? $product_object->wholesale_price : $product_object->retail_price;

            // Скидки
            if ($product_object->discount_min_order && $cart_product["count"] >= $product_object->discount_min_order)
                $price -= $price * ($product_object->discount_percent_max / 100);
            else if ($product_object->discount_percent)
                $price -= $price * ($product_object->discount_percent / 100);

            // Если применена скидка по 5000 в корзине, сразу режем ценник товара на 5%
            if ($isCartStockGot)
                $price -= $price * 0.05;

            // Получили нормальную цифру, иногда потеряли пару копеек (TODO?)
            $price = number_format($price, 2, '.', "");

            $totalPriceByProduct = $cart_product["count"] * $price;

            // Зачем тут поле "totalPriceByProduct"? Это избыточно! TODO
            $order_product                = new OrderProduct();
            $order_product->order_id      = $order->id;
            $order_product->product_id    = $cart_product["id"];
            $order_product->count         = $cart_product["count"];
            $order_product->price         = $price;
            $order_product->total_price   = $totalPriceByProduct;
            $order_product->name          = $product_object->name;
            $order_product->save();
        }

        if (env("APP_DEBUG") != "true") {
            Mail::to($order->email)->send(new OrderDetailsEmail($order));
            Mail::to('site@primgarden.ru')->send(new OrderShopDetailsEmail($order, Auth::user()));
        }

        return response($order->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $order;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function payOnline ($order_id)
    {
        $order = Order::whereId($order_id)->first();

        $userName = 'P253900061104-api';
        $password = 'KxVIaVi8Wa';

        $cart = new PaymentCart();

        foreach ($order->products as $cartPosition) {
            $product = Product::whereId($cartPosition->product_id)->first();

            $cart->AddPosition
            (
                $cartPosition->name,
                $product->vendor_code,
                PaymentQuantity::MakeQuantity($cartPosition->count, $product->unit_name),
                PaymentTax::MakeTax(PaymentTax::NO_RECEIPT_TAX, $cartPosition->total_price * 100),
                $cartPosition->price * 100
            );

            //echo $cartPosition->total_price * 100 . " " . $pricePerUnit * 100 . " " . $cartPosition->count . " " . $cart->GetAmount() . " | ";
        }

        $payment = new Payment($userName, $password);

        $result = $payment->Register($order_id, $cart, 'https://api.primgarden.ru/api/order/success/', 'https://primgarden.ru/order/error/', 'Заказ номер ' . $order_id);

        echo $result;

        if (!isset(json_decode($result)->orderId))
            return;

        $payment_id = json_decode($result)->orderId;

        if (isset($payment_id))
            $order->update([
                "payment_id" => $payment_id,
                "is_synchronized" => false
            ]);

        //$result = $payment->GetOrderStatus("807422e4-5b5a-72b7-9f79-b8eb5e48030b");
        //echo $result;
    }

    public function checkPayment () {

    }

    public function checkPaymentStatus ($payment_id = 0) {
        if ($payment_id == 0 && isset($_GET["orderId"]))
            $payment_id = $_GET["orderId"];
        
        if (empty($payment_id))
            return response("Payment ID not set! Got: \"" . $payment_id . "\"", 403);

        $userName = 'P253900061104-api';
        $password = 'KxVIaVi8Wa';
        $payment = new Payment($userName, $password);

        $result = $payment->GetOrderStatus($payment_id);

        $isPaid = str_contains($result, '"errorCode":"0","errorMessage":"Успешно"');

        $order = Order::where("payment_id", $payment_id)->first();

        $order->update([
            'is_paid' => $isPaid,
            'payment_result' => $result,
            "is_synchronized" => false
        ]);

        return redirect(env('CLIENT_URL')."/order/".($isPaid ? "success" : "error"));
    }
}

<?php

namespace App\Http\Controllers;

use App\ProductCharacteristic;
use Illuminate\Http\Request;

class ProductCharacteristicController extends Controller
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



    public static function update1c($characteristics, $product_id) {
        foreach ($characteristics as $item) {
            $characteristic = ProductCharacteristic::where("product_id", $product_id)
                    ->where("characteristic_id", $item["characteristicId"])
                    ->first()
                ??
                new ProductCharacteristic();

            $characteristic->product_id        = $product_id;
            $characteristic->characteristic_id = $item["characteristicId"];
            $characteristic->value             = $item["value"];

            $characteristic->save();
        }

        return response("success", 200);
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
     * @param  \App\ProductCharacteristic  $productCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCharacteristic $productCharacteristic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCharacteristic  $productCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCharacteristic $productCharacteristic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCharacteristic  $productCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCharacteristic $productCharacteristic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCharacteristic  $productCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCharacteristic $productCharacteristic)
    {
        //
    }
}

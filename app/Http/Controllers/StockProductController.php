<?php

namespace App\Http\Controllers;

use App\StockProduct;
use Illuminate\Http\Request;

class StockProductController extends Controller
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
     * @param  \App\StockProduct  $stockProduct
     * @return \Illuminate\Http\Response
     */
    public function show(StockProduct $stockProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockProduct  $stockProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(StockProduct $stockProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StockProduct  $stockProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockProduct $stockProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StockProduct  $stockProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockProduct $stockProduct)
    {
        //
    }

    public function update1c($products, $stock_id)
    {
        foreach ($products as $item) {
            $stock_product = StockProduct::where("stock_id", $stock_id)
                    ->where("product_id", $item["product_id"])
                    ->first()
                ??
                new StockProduct();

            $stock_product->stock_id             = $stock_id;
            $stock_product->product_id           = $item["product_id"];
            $stock_product->discount_percent     = $item["discount_percent"];
            $stock_product->min_order            = $item["min_order"];
            $stock_product->discount_percent_max = $item["discount_percent_max"];

            $stock_product->save();
        }

        return response("success", 200);
    }
}

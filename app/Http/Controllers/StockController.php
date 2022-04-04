<?php

namespace App\Http\Controllers;

use App\Stock;
use App\StockProduct;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        return response()->json(Stock::all());
    }

    public function update1c (Request $request) {
        foreach ($request->stocks as $item) {
            $stock = Stock::whereId($item["id"])->first() ?? new Stock();

            $stock->id                       =   $item["id"];
            $stock->name                     =   $item["name"];
            $stock->is_active                = ! $item["markDelete"];
            $stock->type                     =   $item["type"];
            $stock->discount_percent_all     =   $item["discount_percent_all"];
            $stock->min_order_all            =   $item["min_order_all"];
            $stock->discount_percent_max_all =   $item["discount_percent_max_all"];

            $stock->save();

            if ($item["products"])
                (new StockProductController)->update1c($item["products"], $item["id"]);
        }

        return response("success", 200);
    }

    public function getBy1c(Request $request) {
        if ($request->has("ids"))
            return Stock::select("id")->whereIn("id", $request->ids)->where("is_active", true)->pluck("id");
        else
            return Stock::select("id")->where("is_active", true)->pluck("id");
    }

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
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}

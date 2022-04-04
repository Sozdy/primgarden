<?php

namespace App\Http\Controllers;

use App\StoreBalance;
use Illuminate\Http\Request;

class StoreBalanceController extends Controller
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

    public function update1c (Request $request) {
        foreach ($request->stock_balances as $item) {
            $storeBalance = StoreBalance::where("product_id", $item["productId"])
                    ->where("store_id", $item["shopId"])
                    ->first()
                ??
                new StoreBalance();

            $storeBalance->product_id = $item["productId"];
            $storeBalance->store_id   = $item["shopId"];
            $storeBalance->value      = $item["left"];

            $storeBalance->save();
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
     * @param  \App\StoreBalance  $storeBalance
     * @return \Illuminate\Http\Response
     */
    public function show(StoreBalance $storeBalance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StoreBalance  $storeBalance
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreBalance $storeBalance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StoreBalance  $storeBalance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoreBalance $storeBalance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StoreBalance  $storeBalance
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreBalance $storeBalance)
    {
        //
    }

    public function getBy1c() {
        return StoreBalance::all();
    }
}

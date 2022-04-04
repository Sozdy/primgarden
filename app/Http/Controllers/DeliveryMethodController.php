<?php

namespace App\Http\Controllers;

use App\DeliveryMethod;
use Illuminate\Http\Request;

class DeliveryMethodController extends Controller
{    public function index()
{
    return response()->json(DeliveryMethod::where("is_active", true)->get());
}

    public function update1c (Request $request) {
        foreach ($request->delivery_methods as $item) {
            $deliveryMethod = DeliveryMethod::whereId($item["id"])->first() ?? new DeliveryMethod();

            $deliveryMethod->id            = $item["id"];
            $deliveryMethod->title         = $item["title"];
            $deliveryMethod->description   = nl2br($item["description"]);
            $deliveryMethod->is_active     = !$item["markDelete"];

            $deliveryMethod->save();
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
     * @param  \App\DeliveryMethod  $deliveryMethod
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryMethod $deliveryMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeliveryMethod  $deliveryMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryMethod $deliveryMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeliveryMethod  $deliveryMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryMethod $deliveryMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeliveryMethod  $deliveryMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryMethod $deliveryMethod)
    {
        //
    }
}

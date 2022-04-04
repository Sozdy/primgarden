<?php

namespace App\Http\Controllers;

use App\CategoryCharacteristic;
use Illuminate\Http\Request;

class CategoryCharacteristicController extends Controller
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
        foreach ($request->category_characteristics as $item) {
            $category_characteristic =
                CategoryCharacteristic::where("category_id", $item["categoryId"])
                    ->where("characteristic_id", $item["characteristicId"])
                    ->first()
                ??
                new CategoryCharacteristic();

            $category_characteristic->category_id       = $item["categoryId"];
            $category_characteristic->characteristic_id = $item["characteristicId"];

            $category_characteristic->save();
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
     * @param  \App\CategoryCharacteristic  $categoryCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryCharacteristic $categoryCharacteristic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CategoryCharacteristic  $categoryCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryCharacteristic $categoryCharacteristic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CategoryCharacteristic  $categoryCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryCharacteristic $categoryCharacteristic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CategoryCharacteristic  $categoryCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryCharacteristic $categoryCharacteristic)
    {
        //
    }
}

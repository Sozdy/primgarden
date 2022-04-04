<?php

namespace App\Http\Controllers;

use App\CharacteristicType;
use Illuminate\Http\Request;

class CharacteristicTypeController extends Controller
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
        foreach ($request->characteristic_types as $item) {
            $characteristic_type =
                CharacteristicType::whereId($item["id"])->first()
                ??
                new CharacteristicType();

            $characteristic_type->id   = $item["id"];
            $characteristic_type->name = $item["name"];

            $characteristic_type->save();
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
     * @param  \App\CharacteristicType  $characteristicType
     * @return \Illuminate\Http\Response
     */
    public function show(CharacteristicType $characteristicType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CharacteristicType  $characteristicType
     * @return \Illuminate\Http\Response
     */
    public function edit(CharacteristicType $characteristicType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CharacteristicType  $characteristicType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CharacteristicType $characteristicType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CharacteristicType  $characteristicType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CharacteristicType $characteristicType)
    {
        //
    }
}

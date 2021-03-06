<?php

namespace App\Http\Controllers;

use App\Characteristic;
use Illuminate\Http\Request;

class CharacteristicController extends Controller
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
        foreach ($request->characteristics as $item) {
            $characteristic =
                Characteristic::whereId($item["id"])->first()
                ??
                new Characteristic();

            $characteristic->id                     = $item["id"];
            $characteristic->name                   = $item["name"];
            $characteristic->characteristic_type_id = $item["typeId"];

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
     * @param  \App\Characteristic  $characteristic
     * @return \Illuminate\Http\Response
     */
    public function show(Characteristic $characteristic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Characteristic  $characteristic
     * @return \Illuminate\Http\Response
     */
    public function edit(Characteristic $characteristic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Characteristic  $characteristic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Characteristic $characteristic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Characteristic  $characteristic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Characteristic $characteristic)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\UserDeliveryAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDeliveryAddressController extends Controller
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
        $user_delivery_address = new UserDeliveryAddress();
        $user_delivery_address->user_id = Auth::user()->id;
        $user_delivery_address->address = $request->address;
        $user_delivery_address->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserDeliveryAddress  $userDeliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function show(UserDeliveryAddress $userDeliveryAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserDeliveryAddress  $userDeliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(UserDeliveryAddress $userDeliveryAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserDeliveryAddress  $userDeliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserDeliveryAddress $userDeliveryAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserDeliveryAddress  $userDeliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDeliveryAddress $userDeliveryAddress)
    {
        $userDeliveryAddress->delete();
    }
}

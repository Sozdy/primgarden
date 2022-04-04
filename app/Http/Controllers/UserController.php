<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getBy1c (Request $request) {
        $users = [];

        if ($request->get("type") == "all")
            $users = User::all();
        else if ($request->get("type") == "new")
            $users = User::where("is_synchronized", false)->get();

        return $users;
    }

    public function setSynchronizedBy1c (Request $request)
    {
        foreach ($request->ids as $item) {
            $user = User::whereId($item)->first();
            $user->is_synchronized = true;
            $user->save();
        }
    }

    public function setModeratedBy1c (Request $request)
    {
        $user = User::whereId($request->get("id"))->first();
        $user->is_moderated = $request->get("is_moderated");
        $user->save();
    }

    public function setCart(Request $request) {
        $user = $request->user();
        $user->cart = $request->cart;
        $user->save();
    }

    public function getCart(Request $request) {
        return $request->user()->cart;
    }

    public function me (Request $request) {
        return $request->user();
    }
}

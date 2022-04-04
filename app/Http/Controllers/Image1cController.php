<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Image1cController extends Controller
{
    function update1c (Request $request) {
        foreach ($request->file() as $key => $file) {
            $destinationPath = base_path()."/client/static/images/1c/";
            $file->move($destinationPath, $key . ".jpg");
        }

        return response("success", 200);
    }
}

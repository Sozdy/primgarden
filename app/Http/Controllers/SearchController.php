<?php

namespace App\Http\Controllers;

use App\Product;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function foo\func;

class SearchController extends Controller
{
    public function query(Request $request)
    {
        $products = Product
            ::with("prices")
            ->with("store_balances")
            ->where(function ($q) use ($request) {
                $q
                    ->where('name', 'LIKE', "%{$request->q}%")
                    ->orWhere('description', 'LIKE', "%{$request->q}%")
                    ->orWhere('vendor_code', 'LIKE', "%{$request->q}%");
            })
            ->whereHas("prices", function ($query) {
                return $query
                    ->where("price_type_id", Auth::user() ? Store::getCurrentStore()->price_type_id : Store::getCurrentStore()->retail_price_type_id)
                    ->where("value", ">", "0");
            })
            ->whereHas("store_balances", function ($query) {
                return $query
                    ->where("store_id", Store::getCurrentStore()->id)
                    ->where("value", ">", "0");
            })
            ->paginate(48);

        return $products;
    }
}

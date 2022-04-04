<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCharacteristic;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        foreach ($request->products as $item) {
            $product = Product::whereId($item["id"])->first() ?? new Product();

            $product->id                    =  $item["id"];
            $product->category_id           =  $item["parentId"];
            $product->name                  =  $item["name"];
            $product->unit_name             =  $item["unit"];
            $product->vendor_code           =  $item["article"];
            $product->description           =  $item["description"];
            $product->is_active             = !$item["markDelete"];
            $product->is_bestseller         =  $item["hit"];
            $product->is_product_of_the_day =  $item["productDay"];
            $product->minimal_order_count   =  $item["minOrder"];
            $product->image_id              =  $item["idPicture"];
            $product->discount_percent      =  $item["stock"]["discount_percent"];
            $product->discount_percent_max  =  $item["stock"]["discount_percent_max"];
            $product->discount_min_order    =  $item["stock"]["min_order"];

            $product->save();

            (new ProductCharacteristicController)->update1c($item["properties"], $item["id"]);
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function getMainPageProducts()
    {
        $productsOfDay = Product::where("is_product_of_the_day", true)
            ->where("is_active", true)
            ->whereHas("prices", function ($query) {
                return $query->where('value', ">", "0");
            })
            ->whereHas("store_balances", function ($query) {
                return $query->where('value', ">", "0");
            })
            ->limit(5)->get();

        $bestsellers = Product::where("is_bestseller", true)
            ->where("is_active", true)
            ->whereHas("prices", function ($query) {
                return $query->where('value', ">", "0");
            })
            ->whereHas("store_balances", function ($query) {
                return $query->where('value', ">", "0");
            })
            ->limit(25)->get();

        //TODO: Сделать дичь ниже
        $promotionalProducts = Product::where("is_active", true)
            ->whereHas("prices", function ($query) {
                return $query->where('value', ">", "0");
            })
            ->whereHas("store_balances", function ($query) {
                return $query->where('value', ">", "0");
            })
            ->where(function ($query) {
                $query->where("discount_percent", "!=", 0)
                    ->orWhere("discount_percent_max", "!=", 0);
            })
            ->limit(25)->get();

        return [
            "productsOfDay" => $productsOfDay,
            "bestsellers" => $bestsellers,
            "promotionalProducts" => $promotionalProducts
        ];
    }

    public function getBy1c(Request $request) {
        if ($request->has("ids"))
            return Product::select("id")->whereIn("id", $request->ids)->where("is_active", true)->pluck("id");
        else
            return Product::select("id")->where("is_active", true)->pluck("id");
    }

    public function getListByIds(Request $request) {
        if ($request->type == "short")
            return Product::select("name", "id", "vendor_code", "image_id", "discount_percent", "discount_percent_max", "discount_min_order", "minimal_order_count")->whereIn("id", $request->ids)->get();

        return Product::whereIn("id", $request->ids)->get();
    }

    public function alsoBy () {
        return Product::where("is_active", true)
            ->whereHas("prices", function ($query) {
                return $query->where('value', ">", "0");
            })
            ->whereHas("store_balances", function ($query) {
                return $query->where('value', ">", "0");
            })->inRandomOrder()->limit(4)->get();
    }
}

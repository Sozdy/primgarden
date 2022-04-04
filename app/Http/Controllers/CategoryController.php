<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryCharacteristic;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\Driver\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return Category::where("parent_id", null)->where("is_active", true)->get();
    }

    public function update1c (Request $request) {
        foreach ($request->categories as $item) {
            $category = Category::whereId($item["id"])->first() ?? new Category();

            $category->id = $item["id"];
            $category->name = $item["name"];
            $category->is_active = !$item["markDelete"];
            $category->parent_id = $item["parentId"] == "" ? null : $item["parentId"];

            $category->save();
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Request $request)
    {
        $recursive_subcategories_ids = $this->get_subcategories_recursive($category->id);
        array_push($recursive_subcategories_ids, $category->id);

        // TODO: УЧИТЫВАТЬ PRICE TYPE ID
        //if (Auth::user())
        //dd($request->cookie("store_id"));

        $products = Product::whereIn("category_id", $recursive_subcategories_ids)
            ->where("is_active", true)
            ->whereHas("prices", function ($query) {
                return $query->where('value', ">", "0");
            })
            ->whereHas("store_balances", function ($query) {
                return $query->where('value', ">", "0");
            });

        // Фильтр по стоимости
        if (($request->has("max_price") || $request->has("min_price")) && $request->has("price_type_id"))
            $products = $products->whereHas('prices', function ($query) use ($request) {
                if ($request->has("max_price"))
                    $query = $query
                        ->where('value', '<=', $request->get("max_price"));

                if ($request->has("min_price"))
                    $query = $query
                        ->where('value', '>=', $request->get("min_price"));

                //"f818adf0-a7b7-11e7-80c6-00155d0c3606"
                return $query->where("price_type_id", $request->get("price_type_id"));
            });

        // Сортировка по стоимости
        if ($request->has("order") && $request->has("price_type_id")) {
            $products = $products->leftJoin('prices', 'products.id', '=', 'prices.product_id')
                ->orderBy('prices.value', $request->get("order"))
                ->select('products.*')
                ->where('prices.price_type_id', $request->get("price_type_id"));
        } else { // Default order by name
            $products = $products->orderBy("name", "asc");
        }

        // Пагинация
        $products = $products->paginate($request->has("limit") ? $request->get("limit") : 12);

        $category["min_price"] = Product::whereIn("category_id", $recursive_subcategories_ids)
            ->where('id', function ($query) {
                return $query
                    ->selectRaw("product_id")
                    ->from("prices")
                    ->where("value", function ($query) {
                        return $query
                            ->selectRaw("MIN(value)")
                            ->from("prices")
                            ->limit(1);
                    })
                    ->groupBy("product_id")
                    ->limit(1);
            })->first()->wholesale_price ?? 0;

        $category["max_price"] = Product::whereIn("category_id", $recursive_subcategories_ids)
            ->where('id', function ($query) {
                return $query
                    ->selectRaw("product_id")
                    ->from("prices")
                    ->where("value", function ($query) {
                        return $query
                            ->selectRaw("MAX(value)")
                            ->from("prices")
                            ->limit(1);
                    })
                    ->groupBy("product_id")
                    ->limit(1);
            })->first()->retail_price ?? 10000;

        $subcategories = Category::select("id", "name")
            ->where("parent_id", $category->id)
            ->orderBy("name", "asc")
            ->get();

        return [
            "category"      => $category,
            "subcategories" => $subcategories,
            "products"      => $products
        ];
    }

    public function get_subcategories_recursive($id) {
        $subcategories = Category::where("parent_id", $id)
            ->where("is_active", true)
            ->pluck("id")
            ->toArray();

        $recursive = $subcategories;

        foreach ($subcategories as $id)
            $recursive = array_merge($recursive, $this->get_subcategories_recursive($id));

        return $recursive;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    public function getBy1c(Request $request) {
        if ($request->has("ids"))
            return Category::select("id")->whereIn("id", $request->ids)->where("is_active", true)->pluck("id");
        else
            return Category::select("id")->where("is_active", true)->pluck("id");
    }
}

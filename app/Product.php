<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    const DEFAULT_IMAGE_URL = "/images/default_product_image.jpg";

    protected $fillable = [
        "id",
        "category_id",
        "name",
        "is_active",
        "unit_name",
        "is_bestseller",
        "is_product_of_the_day",
        "minimal_order_count",
        "description",
        "vendor_code",
        "image_id",
        "discount_percent",
        "discount_percent_max",
        "discount_min_order",
    ];
    public $timestamps = false;

    protected $casts = ['id' => 'string'];
    public $incrementing = false;

    protected $appends = [
        'category',
        'characteristics',
        'image_url',
        'retail_price',
        'wholesale_price',
        "maximal_order_count",
        'is_in_stock'
    ];

    protected $hidden = ["image_id"];

    public function getMinimalOrderCountAttribute($default_value) {
        $stock_value = StoreBalance::where("product_id", $this->id)
                ->where("store_id", Store::getCurrentStore()->id)
                ->first()->value ?? 99999999;

        return min($default_value, $stock_value);
    }

    public function getMaximalOrderCountAttribute() {
        return StoreBalance::where("product_id", $this->id)
                ->where("store_id", Store::getCurrentStore()->id)
                ->first()->value ?? 0;
    }

    public function getCategoryAttribute() {
        return Category::whereId($this->category_id)->first();
    }

    public function getCharacteristicsAttribute() {
        return ProductCharacteristic::where("product_id", $this->id)
            ->where("value", "!=", "0")->get();
    }

    public function getImageUrlAttribute() {
        $image_url = "";

        if (!$this->image_id)
            $image_url = self::DEFAULT_IMAGE_URL;
        else {
            $filename = base_path()."/client/static/images/1c/".$this->image_id.".jpg";

            if (file_exists($filename))
                $image_url = "/images/1c/" . $this->image_id . ".jpg";
            else
                $image_url = self::DEFAULT_IMAGE_URL;
        }

        return $image_url;
    }

    public function getRetailPriceAttribute() {
        return Price
            ::where("product_id", $this->id)
            ->where("price_type_id", Store::getCurrentStore()->retail_price_type_id)
            ->first()->value ?? "-";
    }

    public function getWholesalePriceAttribute() {
        return Price
            ::where("product_id", $this->id)
            ->where("price_type_id", Store::getCurrentStore()->price_type_id)
            ->first()->value ?? "-";
    }

    public function getIsInStockAttribute() {
        return
            (StoreBalance
                ::where("product_id", $this->id)
                ->where("store_id", Store::getCurrentStore()->id)
                ->first()->value ?? 0) > 0
            &&
            (Price
                ::where("product_id", $this->id)
                ->where("price_type_id", Store::getCurrentStore()->price_type_id)
                ->first()->value ?? false);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function store_balances()
    {
        return $this->hasMany(StoreBalance::class);
    }
}

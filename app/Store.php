<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Store extends Model
{
    protected $fillable = ["id", "name", "is_active", "price_type_id", "retail_price_type_id"];
    public $timestamps = false;

    protected $casts = ['id' => 'string'];
    public $incrementing = false;

    public static function getCurrentStore()
    {
        // TODO: Хранить где-то айдишник текущего выбранного пользователем на сайте магазина
        //session(['current_store_id' => '57ef3336-3ece-11eb-80fa-00155d0c361e']);
        return Store::whereId(Session::get("current_store_id") ?? env("DEFAULT_STORE_ID", '57ef3336-3ece-11eb-80fa-00155d0c361e'))->first();
    }
}

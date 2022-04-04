<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductCharacteristic extends Model
{
    protected $fillable = ["characteristic_id", "product_id", "value"];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ["characteristic_id", "product_id"];

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where($this->getKeyName()[0], '=', $this[$this->getKeyName()[0]])
            ->where($this->getKeyName()[1], '=', $this[$this->getKeyName()[1]]);

        return $query;
    }

    protected $appends = [
        //'type',
        'name'
    ];

    protected $hidden = ["characteristic_id", "product_id"];

    public function getTypeAttribute() {
        return "А зачем оно тут? Пока не делаю.";//CharacteristicType::whereId($this->characteristic_id)->first();
    }

    public function getNameAttribute() {
        return Characteristic::whereId($this->characteristic_id)->pluck("name")[0];
    }
}

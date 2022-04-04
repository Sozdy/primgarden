<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StoreBalance extends Model
{
    protected $fillable = ["product_id", "store_id", "value"];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ["product_id", "store_id"];

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where($this->getKeyName()[0], '=', $this[$this->getKeyName()[0]])
            ->where($this->getKeyName()[1], '=', $this[$this->getKeyName()[1]]);

        return $query;
    }

    //protected $hidden = ["product_id", "store_id"];
}

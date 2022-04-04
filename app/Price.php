<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable   = ["product_id", "price_type_id", "value"];
    public $timestamps    = false;
    public $incrementing  = false;
    protected $primaryKey = ["price_type_id", "product_id"];
    //protected $hidden     = ["product_id"];

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where($this->getKeyName()[0], '=', $this[$this->getKeyName()[0]])
            ->where($this->getKeyName()[1], '=', $this[$this->getKeyName()[1]]);

        return $query;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

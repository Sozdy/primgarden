<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacteristicType extends Model
{
    protected $fillable = ["id", "name"];
    public $timestamps = false;
}

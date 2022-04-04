<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ["id", "parent_id", "name", "is_active"];
    public $timestamps = false;

    protected $casts = ['id' => 'string'];
    public $incrementing = false;

    protected $appends = [
        'parent',
    ];

    public function getParentAttribute() {
        return Category::whereId($this->parent_id)->first();
    }
}

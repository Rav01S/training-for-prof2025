<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'category_id', 'image_url'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')->first();
    }
}

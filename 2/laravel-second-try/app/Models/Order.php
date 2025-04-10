<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status', 'user_id', 'order_id', 'product_id'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id')->first();
    }

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id')->first();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status', 'userId', 'productId', 'order_id', 'status'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'userId')->first();
    }

    public function product() {
        return $this->hasOne(Product::class, 'id', 'productId')->first();
    }

    public function email() {
        return $this->hasOne(User::class, 'id', 'userId')->first()->email;
    }

    public function price() {
        return $this->hasOne(Product::class, 'id', 'productId')->first()->price;
    }
}

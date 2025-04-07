<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = ['order_id', 'product_id', 'quantity', 'actual_price', 'price', 'total'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($orderItem) {
            $orderItem->total = $orderItem->price * $orderItem->quantity;
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

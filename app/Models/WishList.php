<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $table = 'wish_lists';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function businessCustomer()
    {
        return $this->belongsTo(BusinessCustomer::class, 'business_cusomer_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

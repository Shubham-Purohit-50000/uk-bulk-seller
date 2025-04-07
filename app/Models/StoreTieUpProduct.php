<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreTieUpProduct extends Model
{
    protected $table = 'store_tie_up_products';
    
    protected $fillable = ['store_id', 'product_id', 'price'];

    public function store()
    {
        return $this->belongsTo(User::class, 'store_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

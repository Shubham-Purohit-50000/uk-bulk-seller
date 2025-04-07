<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BargainedPrice extends Model
{
    protected $table = 'bargained_prices';

    protected $fillable = ['product_id', 'user_id', 'price', 'approved_by', 'approver_id'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

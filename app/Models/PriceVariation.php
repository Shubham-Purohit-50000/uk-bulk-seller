<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceVariation extends Model
{
    protected $table = 'price_variations';
    
    protected $fillable = ['product_id', 'level_id', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}

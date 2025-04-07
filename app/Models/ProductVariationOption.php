<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariationOption extends Model
{
    protected $table = 'product_variation_options';

    protected $fillable = ['product_id', 'attribute_id', 'option_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(VariationAttribute::class, 'attribute_id');
    }

    public function option()
    {
        return $this->belongsTo(VariationOption::class, 'option_id');
    }
}

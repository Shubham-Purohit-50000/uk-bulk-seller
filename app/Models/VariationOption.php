<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationOption extends Model
{
    protected $table = 'variation_options';

    protected $fillable = ['variation_id', 'value', 'color_code'];

    public function attribute()
    {
        return $this->belongsTo(VariationAttribute::class, 'variation_id');
    }
}

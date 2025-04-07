<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public function priceVariations()
    {
        return $this->hasMany(PriceVariation::class);
    }
}

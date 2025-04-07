<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationAttribute extends Model
{
    protected $table = 'variation_attributes';

    protected $fillable = ['name'];

    public function options()
    {
        return $this->hasMany(VariationOption::class, 'variation_id');
    }
}

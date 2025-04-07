<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Log;

class Product extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'cost_price',
        'recommended_price',
        'quantity',
        'description',
        'category_id',
        'tag',
        'image',
        'barcode',
    ];

    protected $casts = [
        'image' => 'array',
        'tag' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (is_string($model->tag)) {
                $model->tag = array_map('trim', explode(',', $model->tag));
            }
        });
    }

    public function getTagAttribute($value)
    {
        return json_decode($value);
        // return is_array($value) ? implode(', ', $value) : $value;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name') // Field to generate slug from
            ->saveSlugsTo('slug'); // Field to save the slug
    }

    // Relationship with the parent category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function priceVariations()
    {
        return $this->hasMany(PriceVariation::class);
    }

    public function tieUpStore()
    {
        return $this->hasMany(StoreTieUpProduct::class, 'product_id', 'id');
    }

    public function productVariationOptions(){
        return $this->hasMany(ProductVariationOption::class, 'product_id', 'id');
    }

}

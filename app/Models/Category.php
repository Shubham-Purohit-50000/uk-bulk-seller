<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name') // Field to generate slug from
            ->saveSlugsTo('slug'); // Field to save the slug
    }

    // Relationship with the parent category
    public function category()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function subcategoriesRecursive()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('subcategoriesRecursive');
    }
}

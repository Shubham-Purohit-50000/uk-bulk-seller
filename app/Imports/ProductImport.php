<?php 
namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Product;
use App\Models\Category;
use App\Models\Level;
use App\Models\PriceVariation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info("Processing row: ", $row);

        // Find the category
        $category = Category::where('name', $row['category'])->first();

        // Download and save images
        $imageUrls = array_map('trim', explode(',', $row['image']));
        $savedImages = [];

        foreach ($imageUrls as $imageUrl) {
            try {
                $imageContents = Http::get($imageUrl)->body();
                $imageName = 'images/' . uniqid() . '.webp';
                Storage::disk('public')->put($imageName, $imageContents);
                $savedImages[] = $imageName;
            } catch (Exception $e) {
                Log::error("Failed to download image: $imageUrl | Error: " . $e->getMessage());
            }
        }

        try {
            // Create the product
            $product = Product::create([
                'name' => $row['name'],
                'cost_price' => $row['cost_price'],
                'recommended_price' => $row['recommended_price'],
                'quantity' => $row['quantity'],
                'description' => $row['description'],
                'category_id' => $category ? $category->id : null,
                'tag' => $row['tag'], 
                'image' => $savedImages,
            ]);

            if (!$product) {
                Log::error("Failed to save product: " . json_encode($row));
                return null;
            }

            Log::info("Product created successfully: ID " . $product->id);

            // Handle price variations
            $levels = array_map('trim', explode(',', $row['variation_level']));
            $prices = array_map('trim', explode(',', $row['variation_price']));

            foreach ($levels as $index => $levelName) {
                $level = Level::where('name', $levelName)->first();
                if ($level && isset($prices[$index])) {
                    $price = (float) $prices[$index];
                    if ($price > $product->cost_price && $price <= $product->recommended_price) {
                        PriceVariation::create([
                            'product_id' => $product->id,
                            'level_id' => $level->id,
                            'price' => $price,
                        ]);
                        Log::info("Price variation added: Level {$level->name} - Price {$price}");
                    } else {
                        Log::warning("Invalid price variation for level $levelName: $price");
                    }
                } else {
                    Log::warning("Level not found or invalid price: $levelName");
                }
            }
        } catch (Exception $e) {
            Log::error("Failed to save product or variations: " . $e->getMessage());
        }

        return $product;
    }
}

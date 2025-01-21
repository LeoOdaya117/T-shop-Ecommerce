<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductVariant;
use App\Models\Products;

class ProductVariantSeeder extends Seeder
{
    public function run()
    {
        // Fetch all products
        $products = Products::all();

        // Loop through each product and create variants
        foreach ($products as $product) {
            // Create 2 variants for each product using the ProductVariant factory
            $product->variants()->createMany(ProductVariant::factory(2)->make()->toArray());
        }
        
    }
}

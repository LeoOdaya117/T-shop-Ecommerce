<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'title' => 'T-Shirt 1',
                'slug' => 't-shirt-1',
                'description' => 'Description for T-Shirt 1',
                'image' => 'path/to/image1.jpg',
                'price' => 19.99,
                'quantity' => 100,
                'sku' => 'TSHIRT1',
                'category' => 'Clothing',
                'brand' => 'Brand A',
                'size' => 'M',
                'color' => 'Red',
                'status' => 'active',
                'discount' => 0,
                'stock' => 100,
                'weight' => 0.5,
                'dimensions' => '10x10x1',
            ],
            [
                'title' => 'T-Shirt 2',
                'slug' => 't-shirt-2',
                'description' => 'Description for T-Shirt 2',
                'image' => 'path/to/image2.jpg',
                'price' => 21.99,
                'quantity' => 150,
                'sku' => 'TSHIRT2',
                'category' => 'Clothing',
                'brand' => 'Brand B',
                'size' => 'L',
                'color' => 'Blue',
                'status' => 'active',
                'discount' => 0,
                'stock' => 150,
                'weight' => 0.6,
                'dimensions' => '10x10x1',
            ],
            // Add more products as needed
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

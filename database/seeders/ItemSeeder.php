<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $categories = \App\Models\Category::pluck('id')->toArray();
        
        if (empty($categories)) return;

        $items = [];
        for ($i = 1; $i <= 55; $i++) {
            $items[] = [
                'sku' => 'SKU-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'name' => 'Barang Dummy ' . $i . ' ' . $faker->words(2, true),
                'category_id' => $faker->randomElement($categories),
                'minimum_stock' => $faker->numberBetween(5, 20),
                'current_stock' => $faker->numberBetween(0, 100),
                'price' => $faker->numberBetween(10, 1000) * 1000,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        \App\Models\Item::insert($items);
    }
}

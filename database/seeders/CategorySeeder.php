<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Barang elektronik dan gadget'],
            ['name' => 'Pakaian', 'description' => 'Pakaian pria dan wanita'],
            ['name' => 'Makanan', 'description' => 'Makanan ringan dan bahan pokok'],
            ['name' => 'Minuman', 'description' => 'Minuman kemasan dan sirup'],
            ['name' => 'Peralatan Rumah', 'description' => 'Perabotan dan alat kebersihan'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}

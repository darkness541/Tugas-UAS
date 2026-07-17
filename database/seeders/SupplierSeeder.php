<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            ['name' => 'PT Surya Elektronik', 'contact_person' => 'Budi Santoso', 'phone' => '081122334455', 'address' => 'Jl. Merdeka No. 10'],
            ['name' => 'CV Maju Jaya', 'contact_person' => 'Andi Wijaya', 'phone' => '081233445566', 'address' => 'Jl. Sudirman No. 5'],
            ['name' => 'Toko Sumber Rejeki', 'contact_person' => 'Siti Aminah', 'phone' => '081344556677', 'address' => 'Pasar Induk Blok A1'],
            ['name' => 'PT Global Food', 'contact_person' => 'Joko Anwar', 'phone' => '081455667788', 'address' => 'Kawasan Industri Cikarang'],
            ['name' => 'CV Pakaian Sentosa', 'contact_person' => 'Rini Yulianti', 'phone' => '081566778899', 'address' => 'Tanah Abang Blok B'],
            ['name' => 'UD Makmur Sentosa', 'contact_person' => 'Hasan Basri', 'phone' => '081677889900', 'address' => 'Jl. Diponegoro No. 15'],
            ['name' => 'PT Multi Drink', 'contact_person' => 'Dwi Handayani', 'phone' => '081788990011', 'address' => 'Kawasan Industri Pulo Gadung'],
            ['name' => 'Toko Alat Rumah', 'contact_person' => 'Eko Prasetyo', 'phone' => '081899001122', 'address' => 'Jl. Gajah Mada No. 8'],
            ['name' => 'CV Indo Beras', 'contact_person' => 'Lina Marlina', 'phone' => '081900112233', 'address' => 'Karawang Barat'],
            ['name' => 'PT Snack Nusantara', 'contact_person' => 'Doni Setiawan', 'phone' => '081011223344', 'address' => 'Jl. Raya Bogor KM 20'],
        ];

        foreach ($suppliers as $supplier) {
            \App\Models\Supplier::create($supplier);
        }
    }
}

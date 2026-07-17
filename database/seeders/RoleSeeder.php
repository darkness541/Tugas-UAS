<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Superadmin', 'description' => 'Administrator Utama'],
            ['name' => 'Admin', 'description' => 'Administrator Sistem'],
            ['name' => 'Manajer', 'description' => 'Manajer Operasional'],
            ['name' => 'Staf Gudang', 'description' => 'Staf Operasional Gudang'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $items = \App\Models\Item::all();
        $users = \App\Models\User::pluck('id')->toArray();
        $suppliers = \App\Models\Supplier::pluck('id')->toArray();
        
        if ($items->isEmpty() || empty($users)) return;

        // Reset all item stocks to 0 first
        \App\Models\Item::query()->update(['current_stock' => 0]);

        $transactions = [];
        
        foreach ($items as $item) {
            // Give every item 1-3 INBOUND transactions first
            $inboundCount = $faker->numberBetween(1, 3);
            $totalIn = 0;
            
            for ($i = 0; $i < $inboundCount; $i++) {
                $qty = $faker->numberBetween(20, 100);
                $totalIn += $qty;
                $date = $faker->dateTimeBetween('-1 year', 'now');
                
                $transactions[] = [
                    'item_id' => $item->id,
                    'user_id' => $faker->randomElement($users),
                    'supplier_id' => empty($suppliers) ? null : $faker->randomElement($suppliers),
                    'type' => 'in',
                    'quantity' => $qty,
                    'reference_number' => 'INV-IN-' . strtoupper($faker->bothify('?????-#####')),
                    'transaction_date' => $date,
                    'notes' => 'Stok awal / Restock',
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }
            
            // Give every item 0-2 OUTBOUND transactions
            $outboundCount = $faker->numberBetween(0, 2);
            $totalOut = 0;
            
            for ($i = 0; $i < $outboundCount; $i++) {
                $qty = $faker->numberBetween(1, 15);
                // Ensure we don't negative stock
                if ($totalOut + $qty > $totalIn) break; 
                
                $totalOut += $qty;
                $date = $faker->dateTimeBetween('-6 months', 'now');
                
                $transactions[] = [
                    'item_id' => $item->id,
                    'user_id' => $faker->randomElement($users),
                    'supplier_id' => null,
                    'type' => 'out',
                    'quantity' => $qty,
                    'reference_number' => 'TRX-OUT-' . strtoupper($faker->bothify('?????-#####')),
                    'transaction_date' => $date,
                    'notes' => 'Barang keluar untuk operasional',
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }
            
            // Update actual stock
            $item->update(['current_stock' => $totalIn - $totalOut]);
        }

        // Chunk insert to avoid memory issues
        foreach (array_chunk($transactions, 100) as $chunk) {
            \App\Models\Transaction::insert($chunk);
        }
    }
}

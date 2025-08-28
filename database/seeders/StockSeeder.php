<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        // za svaki postojeći proizvod, ako nema stock, dodaj 50 kom
        $products = DB::table('products')->pluck('id');
        foreach ($products as $pid) {
            $exists = DB::table('stocks')->where('product_id', $pid)->exists();
            if (!$exists) {
                DB::table('stocks')->insert([
                    'product_id' => $pid,
                    'quantity'   => 50,
                    'location'   => 'Magacin 1',
                ]);
            }
        }
    }
}

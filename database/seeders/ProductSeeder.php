<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        
        $catLarge   = DB::table('categories')->where('name', 'Velike sveće')->value('id');
        $catSmall   = DB::table('categories')->where('name', 'Male sveće')->value('id');
        $catScented = DB::table('categories')->where('name', 'Mirisne sveće')->value('id');

        DB::table('products')->insert([
            [
                'category_id' => $catLarge,
                'name'        => 'Sveća 40cm',
                'description' => 'Velika sveća za obrede',
                'price'       => 350.00,
                'unit'        => 'kom',
                'sku'         => 'SV-40',
                'min_stock'   => 10,
            ],
            [
                'category_id' => $catSmall,
                'name'        => 'Sveća 15cm',
                'description' => 'Mala sveća za kućnu upotrebu',
                'price'       => 80.00,
                'unit'        => 'kom',
                'sku'         => 'SV-15',
                'min_stock'   => 25,
            ],
            [
                'category_id' => $catScented,
                'name'        => 'Mirisna lavanda',
                'description' => 'Mirisna sveća – lavanda',
                'price'       => 420.00,
                'unit'        => 'kom',
                'sku'         => 'SV-ML',
                'min_stock'   => 8,
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Velike sveće', 'description' => 'Za crkvene obrede'],
            ['name' => 'Male sveće', 'description' => 'Za kućnu upotrebu'],
            ['name' => 'Mirisne sveće', 'description' => 'Razni mirisi i boje'],
        ]);
    }
}

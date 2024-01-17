<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currencies')->insert([
            [
                'code' => 'RUB',
                'name' => 'Russian Ruble',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'USD',
                'name' => 'United States Dollar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

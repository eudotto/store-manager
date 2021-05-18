<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::create([
            'name' => 'Store 1',
            'cep' => '88301001',
            'address' => 'Av Brasil 1',
            'city' => 'Itajaí',
            'state' => 'Santa Catarina'
        ]);

        Store::create([
            'name' => 'Store 2',
            'cep' => '88301001',
            'address' => 'Av Brasil 1',
            'city' => 'Itajaí',
            'state' => 'Santa Catarina'
        ]);

        Store::create([
            'name' => 'Store 3',
            'cep' => '88301002',
            'address' => 'Av Brasil 2',
            'city' => 'Itajaí',
            'state' => 'Santa Catarina'
        ]);
    }
}

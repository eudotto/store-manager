<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'name' => 'Arisha Barron'
        ]);

        Customer::create([
            'name' => 'Branden Gibson'
        ]);

        Customer::create([
            'name' => 'Rhonda Church'
        ]);

        Customer::create([
            'name' => 'Georgina Hazel'
        ]);
    }
}

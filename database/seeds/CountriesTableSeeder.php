<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Country::query()->insert([
            'name' => 'Brasil',
            'code' => 'br',
        ]);
    }
}

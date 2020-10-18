<?php

use Illuminate\Database\Seeder;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'name' => 'CPF',
            'format' => '999.999.999-99',
            'country_id' => 1,
        ], [
            'name' => 'CNPJ',
            'format' => '99.999.999/9999-99',
            'country_id' => 1,
        ]];

        \App\DocumentType::query()->insert($data);
    }
}

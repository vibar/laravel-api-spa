<?php

use Illuminate\Database\Seeder;

class ContractTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'name' => 'Pessoa física',
            'document_name' => 'CPF',
            'document_format' => '999.999.999-99',
            'country_id' => 1,
        ], [
            'name' => 'Pessoa jurídica',
            'document_name' => 'CNPJ',
            'document_format' => '99.999.999/9999-99',
            'country_id' => 1,
        ]];

        \App\ContractType::query()->insert($data);
    }
}

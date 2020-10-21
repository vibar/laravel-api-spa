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
            'name' => 'Pessoa Física',
            'document_name' => 'CPF',
            'document_format' => '\d{3}\.\d{3}\.\d{3}-\d{2}',
            'document_validator' => 'cpf',
            'country_id' => 1,
        ], [
            'name' => 'Pessoa Jurídica',
            'document_name' => 'CNPJ',
            'document_format' => '\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}',
            'document_validator' => 'cnpj',
            'country_id' => 1,
        ]];

        \App\ContractType::query()->insert($data);
    }
}

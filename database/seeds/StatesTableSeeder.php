<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            'ac' => 'Acre',
            'al' => 'Alagoas',
            'am' => 'Amazonas',
            'ap' => 'Amapá',
            'ba' => 'Bahia',
            'ce' => 'Ceará',
            'df' => 'Distrito Federal',
            'es' => 'Espírito Santo',
            'go' => 'Goiás',
            'ma' => 'Maranhão',
            'mg' => 'Minas Gerais',
            'ms' => 'Mato Grosso do Sul',
            'mt' => 'Mato Grosso',
            'pa' => 'Pará',
            'pb' => 'Paraíba',
            'pe' => 'Pernambuco',
            'pi' => 'Piauí',
            'pr' => 'Paraná',
            'rj' => 'Rio de Janeiro',
            'rn' => 'Rio Grande do Norte',
            'ro' => 'Rondônia',
            'rr' => 'Roraima',
            'rs' => 'Rio Grande do Sul',
            'sc' => 'Santa Catarina',
            'se' => 'Sergipe',
            'sp' => 'São Paulo',
            'to' => 'Tocantins',
        ];

        $data = [];

        foreach ($states as $code => $name) {
            $data[] = [
                'code' => $code,
                'name' => $name,
                'country_id' => 1,
            ];
        }

        \App\State::query()->insert($data);
    }
}

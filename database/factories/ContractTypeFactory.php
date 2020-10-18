<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ContractType;
use App\Country;
use Faker\Generator as Faker;

$factory->define(ContractType::class, function (Faker $faker) {

    return [
        'name' => $faker->words(2, true),
        'document_name' => $faker->word,
        'document_format' => implode('', $faker->randomElements(['9'], 10, true)),
        'document_validator' => null,
        'country_id' => function() {
            return factory(Country::class)->create()->id;
        },
    ];
});

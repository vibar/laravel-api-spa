<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contract;
use App\ContractType;
use App\Property;
use Faker\Generator as Faker;

$factory->define(Contract::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'document' => $faker->randomNumber(9),
        'type_id' => function() {
            return factory(ContractType::class)->create()->id;
        },
        'property_id' => function() {
            return factory(Property::class)->create()->id;
        },
    ];
});

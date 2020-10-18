<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use App\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'email' => $faker->safeEmail,
        'street' => $faker->streetName,
        'number' => (string) $faker->numberBetween(1, 1000),
        'complement' => strtoupper($faker->randomLetter),
        'district' => $faker->streetSuffix,
        'city_id' => function() {
            return factory(City::class)->create()->id;
        }
    ];
});

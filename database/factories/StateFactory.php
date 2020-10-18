<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Country;
use App\State;
use Faker\Generator as Faker;

$factory->define(State::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->stateAbbr,
        'name' => $faker->unique()->state,
        'country_id' => function() {
            return factory(Country::class)->create()->id;
        }
    ];
});

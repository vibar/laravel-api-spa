<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\State::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->stateAbbr,
        'name' => $faker->unique()->state,
        'country_id' => function() {
            return factory(App\Country::class)->create()->id;
        }
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->city,
        'state_id' => function() {
            return factory(App\State::class)->create()->id;
        }
    ];
});

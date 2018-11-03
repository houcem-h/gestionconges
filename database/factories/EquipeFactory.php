<?php

use Faker\Generator as Faker;

$factory->define(App\Equipe::class, function (Faker $faker) {
    return [
        'nom_equipe' => $faker->jobTitle,
    ];
});

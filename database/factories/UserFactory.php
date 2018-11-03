<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'role'=> $faker->numberBetween(0,2),
        'matricule' => $faker->numberBetween(100,999),
        'equipe' => $faker->numberBetween(1,5),
        'soldeConge' => $faker->randomFloat(2,0,99),
        'password' => $password ?: $password = bcrypt('12345'),
        //'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret    
        'remember_token' => str_random(10), 
    ];
});

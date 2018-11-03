<?php

use Faker\Generator as Faker;

$factory->define(App\Conge::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(['Conge', 'Sortie']),
        'date_debut' => $faker->date(),
        'date_fin' => $faker->date(),
        'heure_sortie' => $faker->time(),
        'duree' => $faker->randomDigit(),
        'motif' => $faker->randomElement(['Affaire personnelle', 'Maladie', 'Maternité', 'Sans solde', 'Annuel']),
        'date_reprise' => $faker->date(),
        'heure_reprise' => $faker->time(),
        'etat' => $faker->randomElement(['En attente', 'Valide', 'Refus', 'Correction']),
        'remarque' => $faker->sentence(),
        'created_by' => $faker->numberBetween(2,201),
        'updated_by' => $faker->numberBetween(2,201),
    ];
});

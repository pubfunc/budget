<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence(3),
        'amount' => $faker->numberBetween(1, 9999999),
        'import_id' => str_slug($faker->text(48)),
        'date' => $faker->dateTimeThisYear
    ];
});

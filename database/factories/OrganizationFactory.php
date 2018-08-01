<?php

use Faker\Generator as Faker;

$factory->define(App\Organization::class, function (Faker $faker) {

    $label = $faker->company;

    return [
        'label' => $label,
        'slug' => str_slug($label)
    ];
});

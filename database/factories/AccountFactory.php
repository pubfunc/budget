<?php

use Faker\Generator as Faker;

$factory->define(App\Account::class, function (Faker $faker) {
    return [
        'title' =>  $faker->firstName,
        'type' => $faker->randomElement(App\Account::TYPES),
        'description' => $faker->sentences(2, true),
    ];
});

$factory->state(App\Account::class, App\Account::TYPE_ASSET, function (Faker $faker) {
    return [
        'type' => App\Account::TYPE_ASSET
    ];
});

$factory->state(App\Account::class, App\Account::TYPE_LIABILITY, function (Faker $faker) {
    return [
        'type' => App\Account::TYPE_LIABILITY
    ];
});

$factory->state(App\Account::class, App\Account::TYPE_EQUITY, function (Faker $faker) {
    return [
        'type' => App\Account::TYPE_EQUITY
    ];
});
$factory->state(App\Account::class, App\Account::TYPE_INCOME, function (Faker $faker) {
    return [
        'type' => App\Account::TYPE_INCOME
    ];
});
$factory->state(App\Account::class, App\Account::TYPE_EXPENSE, function (Faker $faker) {
    return [
        'type' => App\Account::TYPE_EXPENSE
    ];
});
<?php

use Faker\Generator as Faker;

$factory->define(App\Account::class, function (Faker $faker) {
    return [
        'title' =>  $faker->firstName,
        'type' => $faker->randomElement(App\Accounting\AccountTypes::all()),
        'description' => $faker->sentences(2, true),
        'currency' => 'ZAR',
    ];
});

$factory->state(App\Account::class, App\Accounting\AccountTypes::ASSET, function (Faker $faker) {
    return [
        'type' => App\Accounting\AccountTypes::ASSET
    ];
});

$factory->state(App\Account::class, App\Accounting\AccountTypes::LIABILITY, function (Faker $faker) {
    return [
        'type' => App\Accounting\AccountTypes::LIABILITY
    ];
});

$factory->state(App\Account::class, App\Accounting\AccountTypes::EQUITY_CONT, function (Faker $faker) {
    return [
        'type' => App\Accounting\AccountTypes::EQUITY_CONT
    ];
});
$factory->state(App\Account::class, App\Accounting\AccountTypes::EQUITY_WITH, function (Faker $faker) {
    return [
        'type' => App\Accounting\AccountTypes::EQUITY_WITH
    ];
});
$factory->state(App\Account::class, App\Accounting\AccountTypes::INCOME, function (Faker $faker) {
    return [
        'type' => App\Accounting\AccountTypes::INCOME
    ];
});
$factory->state(App\Account::class, App\Accounting\AccountTypes::EXPENSE, function (Faker $faker) {
    return [
        'type' => App\Accounting\AccountTypes::EXPENSE
    ];
});
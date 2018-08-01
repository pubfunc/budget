<?php

return [
    'types' => [
        App\Account::TYPE_ASSET => [
            'label' => 'Asset',
            'icon' => 'fas fa-money-check-alt'
        ],
        App\Account::TYPE_LIABILITY => [
            'label' => 'Liability',
            'icon' => 'fas fa-credit-card'
        ],
        App\Account::TYPE_EQUITY => [
            'label' => 'Equity',
            'icon' => 'fas fa-building'
        ],
        App\Account::TYPE_INCOME => [
            'label' => 'Income',
            'icon' => 'fas fa-piggy-bank'
        ],
        App\Account::TYPE_EXPENSE => [
            'label' => 'Expense',
            'icon' => 'fas fa-money-bill-alt'
        ],
    ]
];
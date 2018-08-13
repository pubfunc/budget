<?php

return [
    'types' => [
        App\Accounting\AccountTypes::ASSET => [
            'label' => 'Asset',
            'icon' => 'fas fa-money-check-alt'
        ],
        App\Accounting\AccountTypes::LIABILITY => [
            'label' => 'Liability',
            'icon' => 'fas fa-credit-card'
        ],
        App\Accounting\AccountTypes::EQUITY_CONT => [
            'label' => 'Equity Contribution',
            'icon' => 'fas fa-building'
        ],
        App\Accounting\AccountTypes::EQUITY_WITH => [
            'label' => 'Equity Withdrawal',
            'icon' => 'fas fa-building'
        ],
        App\Accounting\AccountTypes::INCOME => [
            'label' => 'Income',
            'icon' => 'fas fa-piggy-bank'
        ],
        App\Accounting\AccountTypes::EXPENSE => [
            'label' => 'Expense',
            'icon' => 'fas fa-money-bill-alt'
        ],
    ]
];
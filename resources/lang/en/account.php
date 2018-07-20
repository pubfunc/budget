<?php

return [
    'types' => [
        App\Account::TYPE_ASSET => [
            'label' => 'Asset',
            'icon' => 'far fa-money-bill-alt'
        ],
        App\Account::TYPE_LIABILITY => [
            'label' => 'Liability',
            'icon' => 'far fa-credit-card'
        ],
        App\Account::TYPE_CAPITAL => [
            'label' => 'Capital',
            'icon' => 'far fa-building'
        ],
    ]
];
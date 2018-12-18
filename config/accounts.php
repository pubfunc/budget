<?php

return [

    'personal' => [
        App\Accounting\AccountTypes::ASSET => [
            ['title' => 'Cheque Account'],
            ['title' => 'Savings Account'],
        ],
        App\Accounting\AccountTypes::LIABILITY => [
            ['title' => 'Credit Card'],
        ],
        App\Accounting\AccountTypes::INCOME => [
            ['title' => 'Saleries & Bonuses'],
            ['title' => 'Interest Income'],
            ['title' => 'Dividend Income'],
            ['title' => 'Winnings'],
        ],
        App\Accounting\AccountTypes::EXPENSE => [
            ['title' => 'Alcohol & Tobacco'],
            ['title' => 'Bank Fees'],
            ['title' => 'Car Loan'],
            ['title' => 'Cleaning'],
            ['title' => 'Credit Interest'],
            ['title' => 'Health Specialist'],
            ['title' => 'Furniture'],
            ['title' => 'Gadgets'],
            ['title' => 'Groceries'],
            ['title' => 'Grooming & Beauty'],
            ['title' => 'Insurance - Health'],
            ['title' => 'Insurance - Vehicle'],
            ['title' => 'Internet'],
            ['title' => 'Lawn & Garden'],
            ['title' => 'Mobile Phone'],
            ['title' => 'Property Rent'],
            ['title' => 'Vehicle Fuel'],
            ['title' => 'Vehicle Repairs & Maintenence'],
            ['title' => 'Utilities'],
            ['title' => 'Home Improvement & Maintenance'],
        ],
        App\Accounting\AccountTypes::EQUITY_WITH => [
            ['title' => 'Owner Capital Withdrawal'],
        ],
        App\Accounting\AccountTypes::EQUITY_CONT => [
            ['title' => 'Owner Capital Contribution'],
        ],
    ],

];


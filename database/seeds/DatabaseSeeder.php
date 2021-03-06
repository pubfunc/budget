<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{

    const ACCOUNTS_DATA = [
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
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $user = factory(App\User::class)->create([
            'email' => 'base1.christiaan@gmail.com',
        ]);
        // $user = App\User::findOrFail(1);

        $org = factory(App\Organization::class)->create();

        $org->users()->attach($user);

        $accounts = collect([]);

        foreach(self::ACCOUNTS_DATA as $type=>$data){
            foreach($data as $row){
                $new = factory(App\Account::class, 1)
                            ->states($type)
                            ->make($row)
                            ->each(function($account) use ($org){
                                $account->organization()->associate($org)->save();
                            });

                $accounts = $accounts->concat($new);
            }
        }

        // $transactions =
        //     factory(App\Transaction::class, 1000)
        //         ->make()
        //         ->each(function($transaction) use ($accounts, $faker, $org){
        //             $transaction->organization()
        //                 ->associate($org);
        //             $transaction->debitAccount()
        //                 ->associate($accounts->random());
        //             $transaction->creditAccount()
        //                 ->associate($accounts->random());
        //             $transaction->save();
        //         });


    }
}

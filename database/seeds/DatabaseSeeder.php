<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
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

        $assetAccounts =
            factory(App\Account::class, 5)
                ->states(App\Account::TYPE_ASSET)
                ->make()
                ->each(function($account) use ($org){
                    $account->organization()->associate($org)->save();
                });

        $liabilityAccounts =
            factory(App\Account::class, 5)
                ->states(App\Account::TYPE_LIABILITY)
                ->make()
                ->each(function($account) use ($org){
                    $account->organization()->associate($org)->save();
                });

        $capitalAccounts =
            factory(App\Account::class, 3)
                ->states(App\Account::TYPE_CAPITAL)
                ->make()
                ->each(function($account) use ($org){
                    $account->organization()->associate($org)->save();
                });

        $accounts = $assetAccounts->concat($liabilityAccounts)->concat($capitalAccounts);

        $transactions =
            factory(App\Transaction::class, 1000)
                ->make()
                ->each(function($transaction) use ($accounts, $faker){
                    $transaction->debitAccount()
                        ->associate($accounts->random());
                    $transaction->creditAccount()
                        ->associate($accounts->random());
                    $transaction->save();
                });


    }
}

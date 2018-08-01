<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Traits\BelongsToOrganizationTrait;

    const TYPE_ASSET = 'asset';
    const TYPE_LIABILITY = 'liability';
    const TYPE_EQUITY = 'equity';
    const TYPE_EXPENSE = 'expense';
    const TYPE_INCOME = 'income';

    const TYPES = [
        self::TYPE_ASSET,
        self::TYPE_LIABILITY,
        self::TYPE_EQUITY,
        self::TYPE_EXPENSE,
        self::TYPE_INCOME,
    ];

    public $incrementing = false;

    public function transactions(){
        return Transaction::forAccount($this);
    }

    public function debitTransactions() {
        return $this->hasMany(Transaction::class, 'debit_account_id');
    }

    public function creditTransactions() {
        return $this->hasMany(Transaction::class, 'credit_account_id');
    }

}

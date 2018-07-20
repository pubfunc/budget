<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    const TYPE_ASSET = 'asset';
    const TYPE_LIABILITY = 'liabitity';
    const TYPE_CAPITAL = 'capital';

    const TYPES = [
        self::TYPE_ASSET,
        self::TYPE_LIABILITY,
        self::TYPE_CAPITAL
    ];

    public $incrementing = false;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactions(){
        return Transaction::forAccount($this);
    }

    public function debitTransactions() {
        return $this->hasMany(Transaction::class, 'debit_account_id');
    }

    public function creditTransactions() {
        return $this->hasMany(Transaction::class, 'credit_account_id');
    }

    public function getParentIdAttribute(){

        $parts = explode('.', $this->id);
        array_pop($parts);
        return implode('.', $parts);
    }

}

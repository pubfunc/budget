<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $dates = [
        'created_at',
        'updated_at',
        'date'
    ];

    public function scopeForAccount($query, $account){
        return $query->where(function($query) use ($account){
            $query->where('debit_account_id', $account->id)
                ->orWhere('credit_account_id', $account->id);
        });
    }

    public function debitAccount(){
        return $this->belongsTo(Account::class, 'debit_account_id');
    }

    public function creditAccount(){
        return $this->belongsTo(Account::class, 'credit_account_id');
    }
}

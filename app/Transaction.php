<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * A Journal entry documents a two-fold event in which
 * value is debited in one account and the same value is
 * credited in another.
 *
 *  - For the JournalEntry to be valid, the accounting
 *    equation must be in balance.
 *  - Balance: Assets = Liabilities + Equity
 *         0 = Assets - Liabilities - Equity
 *
 */
class Transaction extends Model
{

    use Traits\BelongsToOrganizationTrait;

    protected $fillable = [
        'description',
        'amount',
        'date',
        'debit_account_id',
        'credit_account_id',
        'import_id',
    ];

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

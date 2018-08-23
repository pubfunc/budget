<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Accounting\AccountSides;
use App\Accounting\AccountTypes;
use DateTime;
use Illuminate\Support\Facades\DB;
/**
 * "In accounting, an account is a descriptive storage unit used to collect and store information of similar nature."
 * - https://www.accountingverse.com/accounting-basics/elements-of-accounting.html
 */
class Account extends Model
{
    use Traits\BelongsToOrganizationTrait;

    public function transactions(){
        return Transaction::forAccount($this);
    }

    public function debitTransactions() {
        return $this->hasMany(Transaction::class, 'debit_account_id');
    }

    public function creditTransactions() {
        return $this->hasMany(Transaction::class, 'credit_account_id');
    }

    public function scopeJoinBalances($query, DateTime $date_start = null, DateTime $date_end = null){

        $query->leftJoin('transactions as debit_transactions', 'debit_transactions.debit_account_id', 'accounts.id')
            ->leftJoin('transactions as credit_transactions', 'credit_transactions.credit_account_id', 'accounts.id')
            ->groupBy('accounts.id')
            ->select([
                    'accounts.*',
                    DB::raw('sum(debit_transactions.amount) AS sum_debits'),
                    DB::raw('sum(credit_transactions.amount) AS sum_credits')
            ]);

    }

    public function scopeOfType($query, string $type){
        $query->where('type', $type);
    }

    public function getDebitsAmountAttribute(){
        if($this->sum_debits !== null){
            return $this->normalSide() === AccountSides::DEBIT ? $this->sum_debits : -$this->sum_debits;
        }
        return null;
    }

    public function getCreditsAmountAttribute(){
        if($this->sum_credits !== null){
            return $this->normalSide() === AccountSides::CREDIT ? $this->sum_credits : -$this->sum_credits;
        }
        return null;
    }

    public function normalSide(){
        return AccountTypes::normalBalanceSide($this->type);
    }

}

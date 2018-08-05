<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Accounting\AccountSides;
use App\Accounting\AccountTypes;

/**
 * "In accounting, an account is a descriptive storage unit used to collect and store information of similar nature."
 * - https://www.accountingverse.com/accounting-basics/elements-of-accounting.html
 */
class Account extends Model
{
    use Traits\BelongsToOrganizationTrait;

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

    public function normalSide(){

    }

}

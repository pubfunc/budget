<?php namespace App\Accounting\Statements;

use Brick\Money\Money;
use ArrayAccess;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Statement
{

    public $text;

    public $title;
    public $number;

    public $account_title;
    public $account_number;
    public $account_type;

    public $records = [];

    public $period_start;
    public $period_end;

    public $currency;
    public $open_balance;
    public $close_balance;
    public $balance_side;
}
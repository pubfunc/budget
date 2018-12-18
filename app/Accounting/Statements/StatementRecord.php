<?php namespace App\Accounting\Statements;

use Brick\Money\Money;
use DateTime;

class StatementRecord {

    public $date;
    public $description;
    public $amount;
    public $balance;

    function __construct(DateTime $date, string $description, int $amount, int $balance){
        $this->date = $date;
        $this->description = $description;
        $this->amount = $amount;
        $this->balance = $balance;
    }

}
<?php namespace App\Statements;

use Brick\Money\Money;

class StatementData {

    public $date;
    public $description;
    public $amount;

    function __construct($date, $description, Money $amount){
        $this->date = $date;
        $this->description = $description;
        $this->amount = $amount;
    }

}
<?php namespace App\Statements;

class StatementData {

    public $path;

    public $info = [
        'format' => null,
        'account_title' => null,
        'account_number' => null,
        'open_balance' => null,
        'close_balance' => null,
    ];

    public $transactions = [];
    public $text = null;

    function __construct($format){
        $this->format = $format;
    }

}
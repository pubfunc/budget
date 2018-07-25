<?php namespace App\Statements;

class StatementData {

    public $path;
    public $format;

    public $info = [
        'account_title' => null,
        'account_number' => null,
        'open_balance' => null,
        'close_balance' => null,
    ];

    public $transactions = [];
    public $text = null;


    function __construct($format, $path){
        $this->format = $format;
        $this->path = $path;
    }

}
<?php namespace App\Accounting\Statements\Parsers;

use App\Accounting\Statements\Statement;

use DateTime;

interface StatementParser {

    public function parse(): Statement;
}

<?php namespace App\Accounting\Statements;

use Illuminate\Support\Str;

class StatementParser {

    const FORMAT_FNB_DEBIT_CARD = 'fnb_debit_card';

    public function parseFile($format, $path){

        $method = 'parse'.Str::studly($format).'Format';

        if(method_exists($this, $method)){
            return $this->$method($format, $path)->parse();
        }

        throw new InvalidArgumentException(sprintf('Unknown format, "%s"', $format));
    }


    private function parseFnbDebitCardFormat($format, $path){
        return (new Parsers\FNBDebitCardPDFStatementParser($path));
    }

}

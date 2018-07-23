<?php namespace App\Statements;

use Spatie\PdfToText\Pdf;
use Illuminate\Support\Str;

use InvalidArgumentException;
use Carbon\Carbon;

class StatementParser {

    const FORMAT_FNB_DEBIT_CARD = 'fnb_debit_card';

    const FNB_DEBIT_TRANSACTION_REGEX = "/^([0-9]+\ (?:Jan|Feb))\ ([[:print:]]+)[[:blank:]]+([0-9\.\,]+(?:\ (?:Cr))?)[[:blank:]]+([0-9\.\,]+(?:\ (?:Cr)))[[:blank:]]*([0-9\.]+)?$/mU";
    const FNB_DEBIT_PERIOD_REGEX = "/(?:Statement\ Period\ \:\ )([0-9]+\ [a-zA-Z]+\ [0-9]+)(?:\ to\ )([0-9]+\ [a-zA-Z]+\ [0-9]+)/m";

    public function parseFile($format, $path){

        $method = 'parse'.Str::studly($format).'Format';

        if(method_exists($this, $method)){
            return $this->$method($path);
        }

        throw new InvalidArgumentException(sprintf('Unknown format, "%s"', $format));
    }


    public function parseFnbDebitCardFormat($path){
        $text = $this->pdfToText($path);

        $data = [];

        $count = preg_match(self::FNB_DEBIT_PERIOD_REGEX, $text, $matches);

        if($count === false || $count === 0) throw new InvalidArgumentException('Could not extract statement period.');

        $period_start = Carbon::parse($matches[1]);
        $period_end = Carbon::parse($matches[2])->endOfDay();

        $count = preg_match_all(self::FNB_DEBIT_TRANSACTION_REGEX, $text, $matches, PREG_SET_ORDER);

        $data['transactions'] = [];
        foreach($matches as $i=>$match){

            $date = Carbon::parse($match[1])->year($period_start->year);

            while($date->lt($period_start)){
                $date->addYear();
            }

            $transaction = [
                'date' => $date->toDateTimeString(),
                'description' => $this->cleanLine($match[2]),
                'amount' => $match[3]
            ];

            $data['transactions'][] = $transaction;
        }

        $data['period_start'] = $period_start->toDateTimeString();
        $data['period_end'] = $period_end->toDateTimeString();

        return $data;
    }


    private function pdfToText($path){
        return (new Pdf())
            ->setPdf($path)
            ->setOptions(['layout'])
            ->text();
    }

    private function cleanLine($text){
        return preg_replace('!\s+!', ' ', trim($text));
    }

}

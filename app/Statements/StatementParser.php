<?php namespace App\Statements;

use Spatie\PdfToText\Pdf;
use Illuminate\Support\Str;

use InvalidArgumentException;
use Carbon\Carbon;

class StatementParser {

    const FORMAT_FNB_DEBIT_CARD = 'fnb_debit_card';

    const FNB_DEBIT_TRANSACTION_REGEX = "/^([0-9]+\ (?:[a-zA-Z]{3}))\ ([[:print:]]+)[[:blank:]]+([0-9\.\,]+(?:\ (?:Cr))?)[[:blank:]]+([0-9\.\,]+(?:\ (?:Cr|Dr)))[[:blank:]]*([0-9\.]+)?$/mU";
    const FNB_DEBIT_PERIOD_REGEX = "/(?:Statement\ Period\ \:\ )([0-9]+\ [a-zA-Z]+\ [0-9]+)(?:\ to\ )([0-9]+\ [a-zA-Z]+\ [0-9]+)/m";
    const FNB_AMOUNT_REGEX = "/^([0-9]{1,3},(?:[0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])\ ?(Cr|Dr)?$/";
    const FNB_ACCOUNT_REGEX = "/^([\w+\ ]+\ Account)\ ([0-9]+)$/m";

    public function parseFile($format, $path){

        $method = 'parse'.Str::studly($format).'Format';

        if(method_exists($this, $method)){
            return $this->$method($format, $path);
        }

        throw new InvalidArgumentException(sprintf('Unknown format, "%s"', $format));
    }


    public function parseFnbDebitCardFormat($path){
        $text = $this->pdfToText($path);

        // dd($text);

        

        $count = preg_match(self::FNB_DEBIT_PERIOD_REGEX, $text, $matches);
        if(!$count) throw new InvalidArgumentException('Could not extract statement period.');

        $count = preg_match();

        $period_start = Carbon::parse($matches[1]);
        $period_end = Carbon::parse($matches[2])->endOfDay();

        $count = preg_match_all(self::FNB_DEBIT_TRANSACTION_REGEX, $text, $matches, PREG_SET_ORDER);

        if(!$count) throw new InvalidArgumentException('No transactions found for statement.');

        $currency = 'ZAR';

        $transactions = [];
        foreach($matches as $i=>$match){

            $count = preg_match(self::FNB_AMOUNT_REGEX, $match[3], $amount_matches);

            if($count === false || $count === 0) throw new InvalidArgumentException(sprintf('Encountered invalid transaction amount: "%s"', $match[3]));

            $amount = intval( str_replace(['.',','], [''], $amount_matches[1].$amount_matches[2]) );

            $date = Carbon::parse($match[1])->year($period_start->year);
            while($date->lt($period_start)){
                $date->addYear();
            }

            $transaction = [
                'date' => $date->toDateString(),
                'description' => $this->cleanLine($match[2]),
                'amount' => $amount,
                'side' => ''
            ];

            $transactions[] = $transaction;
        }

        $data = new StatementData('FNB Debit Card Statement', $path);

        $data['period_start'] = $period_start->toDateString();
        $data['period_end'] = $period_end->toDateString();
        $data['text'] = $text;

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

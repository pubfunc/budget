<?php namespace App\Statements;

use Spatie\PdfToText\Pdf;
use Illuminate\Support\Str;

use InvalidArgumentException;
use Carbon\Carbon;

use NumberFormatter;
use Brick\Money\Money;

class StatementParser {

    const FORMAT_FNB_DEBIT_CARD = 'fnb_debit_card';

    const FNB_DEBIT_TRANSACTION_REGEX = "/^([0-9]+\ [a-zA-Z]{3})\ ([[:print:]]+)\ ([0-9\.\,]+\ ?(?:Cr)?)\ ([0-9\.\,]+(?:\ (?:Cr|Dr)))[[:blank:]]*([0-9\.]+)?$/mU";
    const FNB_DEBIT_PERIOD_REGEX = "/(?:Statement\ Period\ \:\ )([0-9]+\ [a-zA-Z]+\ [0-9]+)(?:\ to\ )([0-9]+\ [a-zA-Z]+\ [0-9]+)/m";
    const FNB_AMOUNT_REGEX = "/^([0-9]{1,3},(?:[0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])\ ?(Cr|Dr)?$/";
    const FNB_ACCOUNT_REGEX = "/^([\w+\ ]+)\ Account\ ([0-9]+)$/m";
    const FNB_BALANCE_REGEX = "/^(Opening Balance|Closing Balance)\ ([0-9\.\,]+)\ (Cr)?$/m";
    const FNB_BBST_REGEX = "/BBST([0-9]+).*?([0-9]{6})/s";

    public $path;
    public $format;

    public $attributes = [
        'title' => null,
        'number' => null,
        'account_title' => null,
        'account_number' => null,
        'open_balance' => null,
        'open_side' => null,
        'close_balance' => null,
        'close_side' => null,
    ];

    public $transactions = [];
    public $text = null;

    public function parseFile($format, $path){

        $method = 'parse'.Str::studly($format).'Format';

        if(method_exists($this, $method)){
            return $this->$method($format, $path);
        }

        throw new InvalidArgumentException(sprintf('Unknown format, "%s"', $format));
    }


    public function parseFnbDebitCardFormat($format, $path){
        $this->text = $text = $this->pdfToText($path);

        // dd($text);
        $currency = 'ZAR';
        $number_format = NumberFormatter::create('en_ZA', NumberFormatter::PATTERN_DECIMAL, '#,##0.00');

        if($matches = $this->match(self::FNB_DEBIT_PERIOD_REGEX)){
            $period_start = Carbon::parse($matches[1]);
            $period_end = Carbon::parse($matches[2])->endOfDay();
        }else{
            throw new InvalidArgumentException('Could not extract statement period.');
        }

        if($matches = $this->matchAll(self::FNB_BALANCE_REGEX)){
            foreach($matches as $match){
                if($match[1] === 'Opening Balance'){
                    $open_balance = $this->parseAmount($match[2]);
                    $open_side = isset($match[3]) && $match[3] === 'Cr' ? 'credit' : 'debit';
                }
                if($match[1] === 'Closing Balance'){
                    $close_balance = $this->parseAmount($match[2]);
                    $close_side = isset($match[3]) && $match[3] === 'Cr' ? 'credit' : 'debit';
                }
            }
        }else{
            throw new InvalidArgumentException('Could not extract statement balances.');
        }

        if($matches = $this->matchAll(self::FNB_DEBIT_TRANSACTION_REGEX)){
            $this->transactions = [];
            $balance = ($open_balance * ($open_side === 'credit' ? 1 : -1));
            foreach($matches as $i=>$match){

                if(!($amount_matches = $this->match(self::FNB_AMOUNT_REGEX, $match[3]))){
                    throw new InvalidArgumentException(sprintf('Encountered invalid transaction amount: "%s"', $match[3]));
                }

                $amount = $this->parseAmount($amount_matches[1].$amount_matches[2]);
                $side = isset($amount_matches[3]) && $amount_matches[3] === 'Cr' ? 'credit' : 'debit';

                $date = Carbon::parse($match[1])->year($period_start->year);

                while($date->lt($period_start)){
                    $date->addYear();
                }

                $balance += ($amount * ($side === 'credit' ? 1 : -1));

                $transaction = [
                    'date' => $date,
                    'description' => $match[2],
                    'amount' => Money::ofMinor($amount, $currency),
                    'side' => $side,
                    'balance' => Money::ofMinor($balance, $currency)
                ];

                $this->transactions[] = $transaction;
            }
        }else{
            throw new InvalidArgumentException('No transactions found for statement.');
        }

        if($matches = $this->match(self::FNB_ACCOUNT_REGEX)){
            $this->attributes['account_title'] = $matches[1];
            $this->attributes['account_number'] = $matches[2];
        }

        if($matches = $this->match(self::FNB_BBST_REGEX)){
            $this->attributes['number'] = $matches[1] . '-' . $matches[2];
        }

        $this->attributes['title'] =
            sprintf('%s #%s BBST%s',
                $this->attributes['account_title'],
                $this->attributes['account_number'],
                $this->attributes['number']
            );
        $this->attributes['currency'] = $currency;
        $this->attributes['period_start'] = $period_start;
        $this->attributes['period_end'] = $period_end;
        $this->attributes['open_balance'] = Money::ofMinor($open_balance, $currency);
        $this->attributes['open_side'] = $open_side;
        $this->attributes['close_balance'] = Money::ofMinor($close_balance, $currency);
        $this->attributes['close_side'] = $close_side;

        return $this;
    }

    private function match($regex, $line = false){
        if($line === false) $line = $this->text;
        $count = preg_match($regex, $line, $matches);
        if($count === false || $count === 0) return false;
        return $matches;
    }

    private function matchAll($regex, $line = false){
        if($line === false) $line = $this->text;
        $count = preg_match_all($regex, $line, $matches, PREG_SET_ORDER);
        if($count === false || $count === 0) return false;
        return $matches;
    }

    private function parseAmount($text){
        return floatval(str_replace(',', '', $text)) * 100;
    }

    private function pdfToText($path){
        $text = (new Pdf())
            ->setPdf($path)
            ->setOptions(['layout'])
            ->text();

        return implode(PHP_EOL, array_map(function($line){
            return $this->cleanLine($line);
        }, explode(PHP_EOL, $text)));
    }

    private function cleanLine($text){
        return preg_replace('!\s+!', ' ', trim($text));
    }

}

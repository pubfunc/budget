<?php namespace App\Accounting\Statements\Parsers;

use App\Accounting\Statements\Statement;

use InvalidArgumentException;

use Carbon\Carbon;

use NumberFormatter;
use Brick\Money\Money;

class FNBDebitCardPDFStatementParser extends AbstractPDFStatementParser implements StatementParser {

    const FNB_DEBIT_TRANSACTION_REGEX = "/^([0-9]+\ [a-zA-Z]{3})\ ([[:print:]]+)\ ([0-9\.\,]+\ ?(?:Cr)?)\ ([0-9\.\,]+(?:\ (?:Cr|Dr)))[[:blank:]]*([0-9\.]+)?$/mU";
    const FNB_DEBIT_PERIOD_REGEX = "/(?:Statement\ Period\ \:\ )([0-9]+\ [a-zA-Z]+\ [0-9]+)(?:\ to\ )([0-9]+\ [a-zA-Z]+\ [0-9]+)/m";
    const FNB_AMOUNT_REGEX = "/^([0-9]{1,3},(?:[0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])\ ?(Cr|Dr)?$/";
    const FNB_ACCOUNT_REGEX = "/^([\w+\ ]+)\ Account\ ([0-9]+)$/m";
    const FNB_BALANCE_REGEX = "/^(Opening Balance|Closing Balance)\ ([0-9\.\,]+)\ (Cr)?$/m";
    const FNB_BBST_REGEX = "/BBST([0-9]+).*?([0-9]{6})/s";

    public function parse() : Statement {

        $number_format = NumberFormatter::create('en_ZA', NumberFormatter::PATTERN_DECIMAL, '#,##0.00');

        // parse period
        if($matches = $this->match(self::FNB_DEBIT_PERIOD_REGEX)){
            $period_start = Carbon::parse($matches[1]);
            $period_end = Carbon::parse($matches[2])->endOfDay();
        }else{
            throw new InvalidArgumentException('Could not extract statement period.');
        }


        // parse balances
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

        // parse transactions
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

        // parse account title and number
        if($matches = $this->match(self::FNB_ACCOUNT_REGEX)){
            $this->attributes['account_title'] = $matches[1];
            $this->attributes['account_number'] = $matches[2];
        }

        // parse statement title and number
        if($matches = $this->match(self::FNB_BBST_REGEX)){
            $this->attributes['number'] = $matches[1] . '-' . $matches[2];
        }

        $this->attributes['period_start'] = $period_start;
        $this->attributes['period_end'] = $period_end;

        $this->attributes['open_balance'] = Money::ofMinor($open_balance, $currency);
        $this->attributes['open_side'] = $open_side;
        $this->attributes['close_balance'] = Money::ofMinor($close_balance, $currency);
        $this->attributes['close_side'] = $close_side;

        $this->attributes['title'] =
            sprintf('%s #%s BBST%s',
                $this->attributes['account_title'],
                $this->attributes['account_number'],
                $this->attributes['number']
            );
    }

    private function parseBalances(){



    }

    private function parseTransactions(){

    }

}

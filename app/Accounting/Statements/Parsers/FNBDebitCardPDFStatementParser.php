<?php namespace App\Accounting\Statements\Parsers;

use App\Accounting\Statements\Statement;
use App\Accounting\AccountTypes;
use App\Accounting\AccountSides;

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

        $account_type = AccountTypes::ASSET;
        $balance_side = AccountTypes::normalBalanceSide($account_type);
        $records = [];
        $attributes = [];
        $currency = 'ZAR';

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
                    $open_side = isset($match[3]) && $match[3] === 'Cr' ? AccountSides::DEBIT : AccountSides::CREDIT;
                }
                if($match[1] === 'Closing Balance'){
                    $close_balance = $this->parseAmount($match[2]);
                    $close_side = isset($match[3]) && $match[3] === 'Cr' ? AccountSides::DEBIT : AccountSides::CREDIT;
                }
            }
        }else{
            throw new InvalidArgumentException('Could not extract statement balances.');
        }

        // parse transactions
        if($matches = $this->matchAll(self::FNB_DEBIT_TRANSACTION_REGEX)){
            $this->transactions = [];
            $balance = ($open_balance * ($open_side === $balance_side ? 1 : -1));
            foreach($matches as $i=>$match){

                if(!($amount_matches = $this->match(self::FNB_AMOUNT_REGEX, $match[3]))){
                    throw new InvalidArgumentException(sprintf('Encountered invalid transaction amount: "%s"', $match[3]));
                }

                $amount = $this->parseAmount($amount_matches[1].$amount_matches[2]);
                $side = isset($amount_matches[3]) && $amount_matches[3] === 'Cr' ? AccountSides::DEBIT : AccountSides::CREDIT;

                $date = Carbon::parse($match[1])->year($period_start->year);

                while($date->lt($period_start)){
                    $date->addYear();
                }

                $normal = ($amount * ($side === $balance_side ? 1 : -1));
                $balance += $normal;

                $record = [
                    'date' => $date,
                    'description' => $match[2],
                    'amount' => $amount,
                    'side' => $side,
                    'normal' => $normal,
                    'balance' => $balance
                ];

                $records[] = $record;
            }
        }else{
            throw new InvalidArgumentException('No transactions found for statement.');
        }

        // parse account title and number
        if($matches = $this->match(self::FNB_ACCOUNT_REGEX)){
            $attributes['account_title'] = $matches[1];
            $attributes['account_number'] = $matches[2];
        }

        // parse statement title and number
        if($matches = $this->match(self::FNB_BBST_REGEX)){
            $attributes['number'] = $matches[1] . '-' . $matches[2];
        }

        $attributes['currency'] = $currency;
        $attributes['account_type'] = $account_type;
        $attributes['balance_side'] = $balance_side;

        $attributes['period_start'] = $period_start;
        $attributes['period_end'] = $period_end;

        $attributes['open_balance'] = $open_balance;
        $attributes['open_side'] = $open_side;
        $attributes['close_balance'] = $close_balance;
        $attributes['close_side'] = $close_side;
        $attributes['text'] = $this->text;

        $attributes['title'] =
            sprintf('%s #%s BBST%s',
                $attributes['account_title'],
                $attributes['account_number'],
                $attributes['number']
            );

        return new Statement($attributes, $records);
    }

    private function parseBalances(){



    }

    private function parseTransactions(){

    }

}

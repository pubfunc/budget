<?php namespace App\Accounting\Statements\Parsers;

use App\Accounting\Statements\Statement;
use App\Accounting\Statements\StatementRecord;
use App\Accounting\Statements\Exceptions\InvalidStatementFormatException;
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

        $statement = new Statement();

        $statement->text = $this->text;
        $statement->account_type = AccountTypes::ASSET;
        $statement->balance_side = $balance_side = AccountTypes::normalBalanceSide($statement->account_type);
        $statement->currency = 'ZAR';

        // parse period
        if($matches = $this->match(self::FNB_DEBIT_PERIOD_REGEX)){
            $statement->period_start = Carbon::parse($matches[1]);
            $statement->period_end = Carbon::parse($matches[2])->endOfDay();
        }else{
            throw new InvalidStatementFormatException('Could not extract statement period.');
        }


        // parse balances
        if($matches = $this->matchAll(self::FNB_BALANCE_REGEX)){

            foreach($matches as $match){
                if($match[1] === 'Opening Balance'){
                    $open_side = isset($match[3]) && $match[3] === 'Cr' ? AccountSides::DEBIT : AccountSides::CREDIT;
                    $statement->open_balance = $this->parseAmount($match[2]) * ($open_side === $balance_side ? 1 : -1);
                }
                if($match[1] === 'Closing Balance'){
                    $close_side = isset($match[3]) && $match[3] === 'Cr' ? AccountSides::DEBIT : AccountSides::CREDIT;
                    $statement->close_balance = $this->parseAmount($match[2]) * ($close_side === $balance_side ? 1 : -1);
                }
            }
        }else{
            throw new InvalidStatementFormatException('Could not extract statement balances.');
        }

        // parse transactions
        if($matches = $this->matchAll(self::FNB_DEBIT_TRANSACTION_REGEX)){
            $this->transactions = [];
            $balance = $statement->open_balance;
            foreach($matches as $i=>$match){

                if(!($amount_matches = $this->match(self::FNB_AMOUNT_REGEX, $match[3]))){
                    throw new InvalidStatementFormatException(sprintf('Encountered invalid transaction amount: "%s"', $match[3]));
                }

                $amount = $this->parseAmount($amount_matches[1].$amount_matches[2]);
                $side = isset($amount_matches[3]) && $amount_matches[3] === 'Cr' ? AccountSides::DEBIT : AccountSides::CREDIT;

                $date = Carbon::parse($match[1])->year($statement->period_start->year);

                while($date->lt($statement->period_start)){
                    $date->addYear();
                }

                $normal = ($amount * ($side === $balance_side ? 1 : -1));
                $balance += $normal;

                $record = new StatementRecord($date, $match[2], $normal, $balance);

                $statement->records[] = $record;
            }
        }else{
            throw new InvalidStatementFormatException('No transactions found for statement.');
        }

        // parse account title and number
        if($matches = $this->match(self::FNB_ACCOUNT_REGEX)){
            $statement->account_title = $matches[1];
            $statement->account_number = $matches[2];
        }

        // parse statement title and number
        if($matches = $this->match(self::FNB_BBST_REGEX)){
            $statement->number = $matches[1] . '-' . $matches[2];
        }

        $statement->title =
            sprintf('%s #%s BBST%s',
                $statement->account_title,
                $statement->account_number,
                $statement->number
            );


        return $statement;
    }

    private function parseBalances(){



    }

    private function parseTransactions(){

    }

}

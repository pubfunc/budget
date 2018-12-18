<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Accounting\Statements\StatementParser;
use App\Accounting\AccountSides;
use App\Accounting\AccountTypes;
use App\Statement;
use App\Organization;
use App\Transaction;

class StatementController extends Controller
{

    public function uploader(Organization $org){

        return view('statement.statement-upload');
    }

    public function upload(Organization $org, Request $request){

        $request->validate([
            'format'=> ['required', Rule::in(array_keys(trans('statement.formats')))],
            'file' => 'required|file|mimetypes:application/pdf|max:2000'
        ]);

        $file = $request->file('file');

        $statementData = (new StatementParser())->parseFile($request->format, $file->path());

        $statement = new Statement();
        $statement->title = $statementData->title;
        $statement->filename = $file->getClientOriginalName();
        $statement->format = $request->format;
        $statement->path = $file->store('statements');
        $statement->period_start = $statementData->period_start;
        $statement->period_end = $statementData->period_end;
        $statement->organization()->associate($org);
        $statement->save();

        return redirect()->route('statement.preview', $statement->id);

    }

    public function preview(Organization $org, Statement $statement){

        $data = (new StatementParser())->parseFile($statement->format, $statement->fullPath());

        $importAccounts = $org->accounts()->ofType($data->account_type)->get();

        return view('statement.statement-preview', compact('statement', 'data', 'importAccounts'));
    }

    public function import(Organization $org, Statement $statement, Request $request){

        $account = $org->accounts()->findOrFail($request->account_id);
        $balance_side = AccountTypes::normalBalanceSide($account->type);

        $data = (new StatementParser())->parseFile($statement->format, $statement->fullPath());

        foreach($data->records as $record){
            $transaction = new Transaction();
            $transaction->organization()->associate($org);
            $transaction->date = $record->date;
            $transaction->description = $record->description;
            $transaction->amount = abs($record->amount);

            $side = $record->amount >= 0 ? $balance_side : AccountSides::opposite($balance_side);

            if($side === AccountSides::DEBIT){
                $transaction->debitAccount()->associate($account);
            }elseif($side === AccountSides::CREDIT){
                $transaction->creditAccount()->associate($account);
            }

            $transaction->save();
        }

        return redirect()->route('transaction.index');
    }

    public function index(Organization $org){

        $statements = $org->statements()->get();

        return view('statement.statement-index', compact('statements'));
    }

    public function destroy($id){


    }

}

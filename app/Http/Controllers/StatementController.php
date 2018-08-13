<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Accounting\Statements\StatementParser;
use App\Statement;
use App\Organization;

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
        $statement->title = $statementData->attributes['title'];
        $statement->filename = $file->getClientOriginalName();
        $statement->format = $request->format;
        $statement->path = $file->store('statements');
        $statement->period_start = $statementData->attributes['period_start'];
        $statement->period_end = $statementData->attributes['period_end'];
        $statement->organization()->associate($org);
        $statement->save();

        return redirect()->route('statement.preview', $statement->id);

    }

    public function preview(Organization $org, Statement $statement){

        $statement_data = (new StatementParser())->parseFile($statement->format, $statement->fullPath());

        return view('statement.statement-preview', compact('statement', 'statement_data'));
    }

    public function index(Organization $org){

        $statements = $org->statements()->get();

        return view('statement.statement-index', compact('statements'));
    }

    public function destroy($id){


    }

}

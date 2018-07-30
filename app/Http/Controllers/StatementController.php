<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Statements\StatementParser;
use App\Statement;

class StatementController extends Controller
{

    public function uploader(){


        return view('statements.statement-upload');
    }

    public function upload(Request $request){

        $user = $this->user();

        $request->validate([
            'format'=> ['required', Rule::in(array_keys(trans('statement.formats')))],
            'file' => 'required|file|mimetypes:application/pdf|max:100'
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
        $statement->user()->associate($user);
        $statement->save();

        return redirect()->route('statement.preview', $statement->id);

    }

    public function preview($id){
        $user = $this->user();

        $statement = Statement::findOrFail($id);
        $statement_data = (new StatementParser())->parseFile($statement->format, $statement->fullPath());

        return view('statements.statement-preview', compact('statement', 'statement_data'));
    }

    public function index(){

        $statements = Statement::all();

        return view('statements.statement-index', compact('statements'));
    }

    public function destroy($id){


    }

}

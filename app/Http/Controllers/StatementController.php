<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Statements\StatementParser;

class StatementController extends Controller
{

    public function preview(){


        return view('statements.statement-upload');
    }

    public function upload(Request $request){
        $request->validate([
            'format'=> ['required', Rule::in(array_keys(trans('statement.formats')))],
            'file' => 'required|file|mimetypes:application/pdf|max:100'
        ]);

        $file = $request->file('file');

        if($file->isValid()){

            $statementData = (new StatementParser())->parseFile($request->format, $file->path());

            return dd($statementData);
        }

    }



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Smalot\PdfParser\Parser;
use Spatie\PdfToText\Pdf;

class StatementController extends Controller
{

    public function preview(){


        return view('statements.statement-upload');
    }

    public function upload(Request $request){
        $request->validate([
            'format'=> ['required', Rule::in('fnb')],
            'file' => 'required|file|mimetypes:application/pdf|max:100'
        ]);

        $file = $request->file('file');

        if($file->isValid()){


            $text = (new Pdf())
                    ->setPdf($file->path())
                    ->setOptions(['layout'])
                    ->text();

            $lines = preg_match_all("/^([0-9]+\ (?:Jan|Feb))\ ([[:print:]]+)[[:blank:]]+([0-9\.\,]+(?:\ (?:Cr))?)[[:blank:]]+([0-9\.\,]+(?:\ (?:Cr)))[[:blank:]]*([0-9\.]+)?$/mU", $text, $matches, PREG_SET_ORDER);

            dd($matches);

            return $text;

        }

    }
}

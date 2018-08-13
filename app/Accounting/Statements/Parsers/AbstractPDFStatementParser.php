<?php namespace App\Accounting\Statements\Parsers;

use Spatie\PdfToText\Pdf;

class AbstractPDFStatementParser {

    protected $attributes = [
        'title' => null,
        'number' => null,
        'account_title' => null,
        'account_number' => null,
        'open_balance' => null,
        'close_balance' => null,
    ];

    protected $text = null;
    protected $path = null;

    function __construct(string $path){
        $this->path = $path;
        $this->text = $text = $this->pdfToText($path);
    }

    protected function pdfToText($path){
        $text = (new Pdf())
            ->setPdf($path)
            ->setOptions(['layout'])
            ->text();

        return implode(PHP_EOL, array_map(function($line){
            return $this->cleanLine($line);
        }, explode(PHP_EOL, $text)));
    }

    protected function cleanLine($text){
        return preg_replace('!\s+!', ' ', trim($text));
    }

    protected function parseAmount($text){
        return floatval(str_replace(',', '', $text)) * 100;
    }

    protected function match($regex, $line = false){
        if($line === false) $line = $this->text;
        $count = preg_match($regex, $line, $matches);
        if($count === false || $count === 0) return false;
        return $matches;
    }

    protected function matchAll($regex, $line = false){
        if($line === false) $line = $this->text;
        $count = preg_match_all($regex, $line, $matches, PREG_SET_ORDER);
        if($count === false || $count === 0) return false;
        return $matches;
    }

}

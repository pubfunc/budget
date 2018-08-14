<?php namespace App\Accounting;


class Currencies {

    public static function keys(){
        return array_keys(trans('currencies'));
    }

    public static function map(){
        return array_map(function($type){
            return $type['label'];
        }, trans('currencies'));
    }
}
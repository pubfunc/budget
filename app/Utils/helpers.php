<?php

function currency($amount){
    return 'R ' . number_format($amount / 100, 2);
}

function carbon($timestamp = null){
    if($timestamp === null){
        return Carbon\Carbon::now();
    }
    return Carbon\Carbon::parse($timestamp);
}
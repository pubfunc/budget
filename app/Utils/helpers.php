<?php

function currency($amount){
    return 'R ' . number_format($amount / 100, 2);
}
<?php namespace App\Accounting;


class AccountSides {

    const CREDIT = 'CREDIT';
    const DEBIT = 'DEBIT';

    const ALL = [
        self::CREDIT,
        self::DEBIT,
    ];

    static function opposite($side){
        if($side === self::DEBIT) return self::CREDIT;
        if($side === self::CREDIT) return self::DEBIT;
        throw new InvalidArgumentException("Unknown account side '$side'");
    }

}
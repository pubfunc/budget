<?php

use InvalidArgumentException;

class AccountTypes {

    const ASSET = 'ASSET';
    const LIABILITY = 'LIABILITY';
    const EQUITY_CONT = 'EQUITY_CONT';
    const EQUITY_WITH = 'EQUITY_WITH';
    const EXPENSE = 'EXPENSE';
    const INCOME = 'INCOME';

    const ALL = [
        self::ASSET,
        self::LIABILITY,
        self::EQUITY_CONT,
        self::EQUITY_WITH,
        self::INCOME,
        self::EXPENSE,
    ];

    public static function normalBalanceSide($type){
        switch($type){
            case self::ASSET:
            case self::EQUITY_WITH:
            case self::EXPENSE:
                return AccountSides::DEBIT;
            case self::INCOME:
            case self::LIABILITY:
            case self::EQUITY_CONT:
                return AccountSides::CREDIT;
        }
        throw new InvalidArgumentException("Invalid AccountType '{$type}'");
    }

}
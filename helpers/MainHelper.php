<?php

namespace app\helpers;

class MainHelper
{
    const STATES = [
        1 => 'Активный',
        0 => 'Пассивный'
    ];

    const REPORT_STATES = [
        1 => 'Подтвержденный',
        0 => 'Неподтвержденный'
    ];

    const UNITS = [
        'шт' => 'шт',
        'кг' => 'кг'
    ];

    public static function priceFormat($price)
    {
        return  number_format($price, 2, '.', ' ');
    }

    public static function amountFormat($price)
    {
        return  number_format($price, 0, '', ' ');
    }
}
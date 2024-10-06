<?php

namespace app\helpers;

class MainHelper
{
    const STATES = [
        1 => 'Активный',
        0 => 'Пассивный'
    ];

    const UNITS = [
        'шт' => 'шт',
        'кг' => 'кг'
    ];

    public static function priceFormat($price)
    {
        return  number_format($price, 2, '.', ' ');
    }
}
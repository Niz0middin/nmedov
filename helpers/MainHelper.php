<?php

namespace app\helpers;

class MainHelper
{
    const STATES = [
        1 => 'Активный',
        0 => 'Неактивный'
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

    public static function getDaysWithoutSundays($month) {
        $year_month = explode("-", $month);
        $year = $year_month[0];
        $month = $year_month[1];
        // Get the number of days in the month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $nonSundayCount = 0;

        // Loop through each day of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            // Create a date string
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);

            // Check if the day is not Sunday (0 = Sunday in PHP's date('w'))
            if (date('w', strtotime($date)) != 0) {
                $nonSundayCount++;
            }
        }

        return $nonSundayCount;
    }
}
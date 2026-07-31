<?php

use Paradox\NepaliDate\Data\NepaliMonth;
use Paradox\NepaliDate\Data\NepaliWeekDay;


if (! function_exists('nepali_month')) {

    function nepali_month(int $month): string
    {
        return NepaliMonth::name($month);
    }
}


if (! function_exists('nepali_week')) {

    function nepali_week(int $day): string
    {
        return NepaliWeekDay::name($day);
    }
}


if (! function_exists('nepali_short_week')) {

    function nepali_short_week(int $day): string
    {
        return NepaliWeekDay::short($day);
    }
}

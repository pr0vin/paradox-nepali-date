<?php

use Paradox\NepaliDate\Services\Converter;
use Paradox\NepaliDate\Data\NepaliMonth;
use Paradox\NepaliDate\Data\NepaliWeekDay;
use Paradox\NepaliDate\Objects\NepaliDate as NepaliDateObject;


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


if (! function_exists('ad_to_bs')) {

    function ad_to_bs(string $date): NepaliDateObject
    {
        return (new Converter())
            ->adToBs($date);
    }
}


if (! function_exists('bs_to_ad')) {

    function bs_to_ad(
        int $year,
        int $month,
        int $day
    ): string {

        return (new Converter())
            ->bsToAd($year, $month, $day)
            ->format('Y-m-d');
    }
}

<?php

use Carbon\Carbon;
use Paradox\NepaliDate\Data\NepaliMonth;
use Paradox\NepaliDate\Data\NepaliWeekDay;
use Paradox\NepaliDate\Objects\EnglishDate;
use Paradox\NepaliDate\Objects\NepaliDate as NepaliDateObject;
use Paradox\NepaliDate\Services\Converter;
use Paradox\NepaliDate\Support\Formatter;

if (!function_exists('nepali_month')) {

    /**
     * Get Nepali month name.
     */
    function nepali_month(int $month): string
    {
        return NepaliMonth::name($month);
    }
}

if (!function_exists('nepali_week')) {

    /**
     * Get Nepali week day name.
     */
    function nepali_week(int $day): string
    {
        return NepaliWeekDay::name($day);
    }
}

if (!function_exists('nepali_short_week')) {

    /**
     * Get Nepali short week day.
     */
    function nepali_short_week(int $day): string
    {
        return NepaliWeekDay::short($day);
    }
}

if (!function_exists('ad_to_bs')) {

    /**
     * Convert AD to BS.
     */
    function ad_to_bs(Carbon|string $date): NepaliDateObject
    {
        return app(Converter::class)
            ->adToBs($date);
    }
}

if (!function_exists('bs_to_ad')) {
    /**
     * Convert BS date string to AD.
     */
    function bs_to_ad(string $date): EnglishDate
    {
        [$year, $month, $day] = array_map(
            'intval',
            explode('-', $date)
        );

        return app(Converter::class)->bsToAd(
            $year,
            $month,
            $day
        );
    }
}

if (!function_exists('today_bs')) {

    /**
     * Today's BS date.
     */
    function today_bs(): NepaliDateObject
    {
        return app(Converter::class)
            ->adToBs(now());
    }
}

if (!function_exists('now_bs')) {

    /**
     * Current BS date.
     */
    function now_bs(): NepaliDateObject
    {
        return app(Converter::class)
            ->adToBs(now());
    }
}

if (!function_exists('today_ad')) {

    /**
     * Today's AD date.
     */
    function today_ad(): EnglishDate
    {
        return new EnglishDate(today());
    }
}

if (!function_exists('now_ad')) {

    /**
     * Current AD date.
     */
    function now_ad(): EnglishDate
    {
        return new EnglishDate(now());
    }
}
if (! function_exists('toNepaliNumber')) {
    function toNepaliNumber(string|int $number): string
    {
        return Formatter::toNepaliNumber($number);
    }
}

if (! function_exists('toEnglishNumber')) {
    function toEnglishNumber(string $number): string
    {
        return Formatter::toEnglishNumber($number);
    }
}

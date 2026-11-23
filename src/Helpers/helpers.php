
<?php

use Carbon\Carbon;
use Paradox\NepaliDate\Data\NepaliMonth;
use Paradox\NepaliDate\Data\NepaliWeekDay;
use Paradox\NepaliDate\Objects\EnglishDate;
use Paradox\NepaliDate\Objects\NepaliDate as NepaliDateObject;
use Paradox\NepaliDate\Services\Converter;
use Paradox\NepaliDate\Support\Formatter;

/**
 * Get Nepali month name.
 */
if (!function_exists('nepali_month')) {
    function nepali_month(int $month): string
    {
        return NepaliMonth::name($month);
    }
}

/**
 * Get Nepali weekday name.
 */
if (!function_exists('nepali_week')) {
    function nepali_week(int $day): string
    {
        return NepaliWeekDay::name($day);
    }
}

/**
 * Get short Nepali weekday name.
 */
if (!function_exists('nepali_short_week')) {
    function nepali_short_week(int $day): string
    {
        return NepaliWeekDay::short($day);
    }
}

/**
 * Convert AD date to BS.
 */
if (!function_exists('ad_to_bs')) {
    function ad_to_bs(Carbon|string $date): NepaliDateObject
    {
        return app(Converter::class)->adToBs($date);
    }
}

/**
 * Convert BS date to AD.
 *
 * Expected format: YYYY-MM-DD
 */
if (!function_exists('bs_to_ad')) {
    function bs_to_ad(string $date): EnglishDate
    {
        if (!preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $date)) {
            throw new InvalidArgumentException(
                'Invalid BS date format. Expected YYYY-MM-DD.'
            );
        }

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

/**
 * Get today's BS date.
 */
if (!function_exists('today_bs')) {
    function today_bs(): NepaliDateObject
    {
        return app(Converter::class)->adToBs(today());
    }
}

/**
 * Get current BS date.
 */
if (!function_exists('now_bs')) {
    function now_bs(): NepaliDateObject
    {
        return today_bs();
    }
}

/**
 * Get today's AD date.
 */
if (!function_exists('today_ad')) {
    function today_ad(): EnglishDate
    {
        return new EnglishDate(today());
    }
}

/**
 * Get current AD date.
 */
if (!function_exists('now_ad')) {
    function now_ad(): EnglishDate
    {
        return today_ad();
    }
}

/**
 * Convert English numbers to Nepali numbers.
 */
if (!function_exists('toNepaliNumber')) {
    function toNepaliNumber(string|int $number): string
    {
        return Formatter::toNepaliNumber($number);
    }
}

/**
 * Convert Nepali numbers to English numbers.
 */
if (!function_exists('toEnglishNumber')) {
    function toEnglishNumber(string|int $number): string
    {
        return Formatter::toEnglishNumber((string) $number);
    }
}

if (!function_exists('bs_year')) {
    function bs_year(): int
    {
        return today_bs()->year();
    }
}

if (!function_exists('bs_month')) {
    function bs_month(): int
    {
        return today_bs()->month();
    }
}

if (!function_exists('bs_day')) {
    function bs_day(): int
    {
        return today_bs()->day();
    }
}

if (!function_exists('bs_readable')) {
    function bs_readable(?string $week = null): string
    {
        return today_bs()->readable($week);
    }
}

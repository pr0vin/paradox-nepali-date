<?php

namespace Paradox\NepaliDate\Support;

use Paradox\NepaliDate\Data\NepaliMonth;
use Paradox\NepaliDate\Data\NepaliWeekDay;

class Formatter
{
    /**
     * English digits.
     */
    protected const ENGLISH = [
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9'
    ];

    /**
     * Nepali digits.
     */
    protected const NEPALI = [
        '०',
        '१',
        '२',
        '३',
        '४',
        '५',
        '६',
        '७',
        '८',
        '९'
    ];

    /**
     * Convert English digits to Nepali.
     */
    public static function toNepaliNumber(
        string|int $number
    ): string {

        return str_replace(
            self::ENGLISH,
            self::NEPALI,
            (string) $number
        );
    }

    /**
     * Convert Nepali digits to English.
     */
    public static function toEnglishNumber(
        string $number
    ): string {

        return str_replace(
            self::NEPALI,
            self::ENGLISH,
            $number
        );
    }

    /**
     * Nepali month name.
     */
    public static function month(
        int $month
    ): string {

        return NepaliMonth::name($month);
    }

    /**
     * Nepali short month.
     */

    /**
     * Nepali week name.
     */
    public static function week(
        int $day
    ): string {

        return NepaliWeekDay::name($day);
    }

    /**
     * Nepali short week.
     */
    public static function shortWeek(
        int $day
    ): string {

        return NepaliWeekDay::short($day);
    }
}

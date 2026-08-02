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
        '9',
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
        '९',
    ];

    /**
     * Convert English digits to Nepali.
     */
    public static function toNepaliNumber(string|int $number): string
    {
        return str_replace(
            self::ENGLISH,
            self::NEPALI,
            (string) $number
        );
    }

    /**
     * Convert Nepali digits to English.
     */
    public static function toEnglishNumber(string $number): string
    {
        return str_replace(
            self::NEPALI,
            self::ENGLISH,
            $number
        );
    }

    /**
     * Full month name.
     */
    public static function month(int $month): string
    {
        return NepaliMonth::name($month);
    }

    /**
     * Short month name.
     */
    public static function shortMonth(int $month): string
    {
        return mb_substr(
            self::month($month),
            0,
            3
        );
    }

    /**
     * Full weekday.
     */
    public static function week(int $day): string
    {
        return NepaliWeekDay::name($day);
    }

    /**
     * Short weekday.
     */
    public static function shortWeek(int $day): string
    {
        return NepaliWeekDay::short($day);
    }

    /**
     * Format a BS date.
     */
    public static function format(
        int $year,
        int $month,
        int $day,
        int $weekDay,
        string $format = 'Y-m-d',
        bool $nepaliDigits = false
    ): string {

        $replace = [

            // Year
            'Y' => sprintf('%04d', $year),
            'y' => substr((string) $year, -2),

            // Month
            'm' => sprintf('%02d', $month),
            'n' => $month,
            'F' => self::month($month),
            'M' => self::shortMonth($month),

            // Day
            'd' => sprintf('%02d', $day),
            'j' => $day,

            // Weekday
            'l' => self::week($weekDay),
            'D' => self::shortWeek($weekDay),
        ];

        $result = strtr($format, $replace);

        if ($nepaliDigits) {
            $result = self::toNepaliNumber($result);
        }

        return $result;
    }
}

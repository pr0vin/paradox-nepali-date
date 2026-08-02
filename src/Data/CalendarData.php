<?php

namespace Paradox\NepaliDate\Data;

use InvalidArgumentException;

class CalendarData
{
    /**
     * Calendar dataset cache.
     */
    protected static ?array $calendar = null;

    /**
     * Year days cache.
     */
    protected static array $yearDaysCache = [];

    /**
     * Load calendar data.
     */
    public static function all(): array
    {
        if (self::$calendar === null) {
            self::$calendar = require __DIR__ . '/../../config/calendar.php';
        }

        return self::$calendar;
    }

    /**
     * Get months of a BS year.
     */
    public static function year(int $year): ?array
    {
        return self::all()[$year] ?? null;
    }

    /**
     * Check if year exists.
     */
    public static function hasYear(int $year): bool
    {
        return isset(self::all()[$year]);
    }

    /**
     * Get total days in a BS year.
     */
    public static function yearDays(int $year): int
    {
        if (!self::hasYear($year)) {
            throw new InvalidArgumentException("Unsupported BS year {$year}");
        }

        if (!isset(self::$yearDaysCache[$year])) {
            self::$yearDaysCache[$year] = array_sum(self::year($year));
        }

        return self::$yearDaysCache[$year];
    }

    /**
     * Get days in a BS month.
     */
    public static function monthDays(int $year, int $month): int
    {
        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException("Invalid BS month {$month}");
        }

        $months = self::year($year);

        if ($months === null) {
            throw new InvalidArgumentException("Unsupported BS year {$year}");
        }

        return $months[$month - 1];
    }

    /**
     * Get supported BS years.
     */
    public static function supportedYears(): array
    {
        return array_keys(self::all());
    }

    /**
     * First supported BS year.
     */
    public static function minYear(): int
    {
        return min(self::supportedYears());
    }

    /**
     * Last supported BS year.
     */
    public static function maxYear(): int
    {
        return max(self::supportedYears());
    }
}

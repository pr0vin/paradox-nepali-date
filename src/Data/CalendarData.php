<?php

namespace Paradox\NepaliDate\Data;

class CalendarData
{
    public static function all(): array
    {
        return require __DIR__ . '/../../config/calendar.php';
    }

    public static function year(int $year): ?array
    {
        return self::all()[$year] ?? null;
    }

    public static function monthDays(int $year, int $month): int
    {
        $months = self::year($year);

        if (!$months) {
            throw new \InvalidArgumentException("Unsupported BS year {$year}");
        }

        return $months[$month - 1];
    }
}

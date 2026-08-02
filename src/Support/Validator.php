<?php

namespace Paradox\NepaliDate\Support;

use Paradox\NepaliDate\Data\CalendarData;
use InvalidArgumentException;

class Validator
{
    public static function validateBS(int $year, int $month, int $day): void
    {
        $months = CalendarData::year($year);

        if (!$months) {
            throw new InvalidArgumentException("Unsupported BS year: {$year}");
        }

        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException("Invalid BS month.");
        }

        $maxDays = CalendarData::monthDays($year, $month);

        if ($day < 1 || $day > $maxDays) {
            throw new InvalidArgumentException("Invalid BS day.");
        }
    }
}

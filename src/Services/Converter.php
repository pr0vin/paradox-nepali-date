<?php

namespace Paradox\NepaliDate\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use Paradox\NepaliDate\Data\CalendarData;
use Paradox\NepaliDate\Objects\EnglishDate;
use Paradox\NepaliDate\Objects\NepaliDate as NepaliDateObject;
use Paradox\NepaliDate\Support\Validator;

class Converter
{
    private const BS_REFERENCE_YEAR = 2000;
    private const BS_REFERENCE_MONTH = 1;
    private const BS_REFERENCE_DAY = 1;

    // 2000-01-01 BS = 1943-04-14 AD
    private const AD_REFERENCE_DATE = '1943-04-14';

    protected array $yearDaysCache = [];

    /**
     * Convert a BS date to an AD date.
     */
    public function bsToAd(int $year, int $month, int $day): EnglishDate
    {
        Validator::validateBS($year, $month, $day);

        $days = $this->totalBsDays($year, $month, $day);

        return new EnglishDate(
            Carbon::parse(self::AD_REFERENCE_DATE)->addDays($days)
        );
    }

    /**
     * Convert an AD date to a BS date.
     */
    public function adToBs(Carbon|string $date): NepaliDateObject
    {
        $date = $date instanceof Carbon
            ? $date->copy()->startOfDay()
            : Carbon::parse($date)->startOfDay();

        $reference = Carbon::parse(self::AD_REFERENCE_DATE)->startOfDay();

        $days = (int) $reference->diffInDays($date, false);

        if ($days < 0) {
            throw new InvalidArgumentException(
                'Date is before the supported BS calendar range.'
            );
        }

        $year = self::BS_REFERENCE_YEAR;
        $month = self::BS_REFERENCE_MONTH;
        $day = self::BS_REFERENCE_DAY;

        while ($days >= $this->yearDays($year)) {
            $days -= $this->yearDays($year);
            $year++;
        }

        while ($days >= CalendarData::monthDays($year, $month)) {
            $days -= CalendarData::monthDays($year, $month);
            $month++;

            if ($month > 12) {
                $month = 1;
                $year++;
            }
        }

        $day += $days;

        return new NepaliDateObject($year, $month, $day);
    }



    /**
     * Calculate total days between the reference BS date
     * and the supplied BS date.
     */
    private function totalBsDays(
        int $year,
        int $month,
        int $day
    ): int {
        $total = 0;

        for ($y = self::BS_REFERENCE_YEAR; $y < $year; $y++) {
            $total += $this->yearDays($y);
        }

        for ($m = 1; $m < $month; $m++) {
            $total += CalendarData::monthDays($year, $m);
        }

        return $total + ($day - 1);
    }

    /**
     * Get the number of days in a BS year.
     */
    private function yearDays(int $year): int
    {
        if (!isset($this->yearDaysCache[$year])) {
            $this->yearDaysCache[$year] = CalendarData::yearDays($year);
        }

        return $this->yearDaysCache[$year];
    }
}

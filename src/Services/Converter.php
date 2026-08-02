<?php

namespace Paradox\NepaliDate\Services;

use Carbon\Carbon;
use Paradox\NepaliDate\Data\CalendarData;
use Paradox\NepaliDate\Objects\NepaliDate as NepaliDateObject;
use Paradox\NepaliDate\Support\Validator;
use InvalidArgumentException;
use Paradox\NepaliDate\Objects\EnglishDate;

class Converter
{
    /**
     * BS reference
     */
    private const BS_REFERENCE_YEAR = 2000;
    private const BS_REFERENCE_MONTH = 1;
    private const BS_REFERENCE_DAY = 1;

    /**
     * AD reference
     * 2000-01-01 BS = 1943-04-14 AD
     */
    private const AD_REFERENCE_DATE = '1943-04-14';

    /**
     * Cache total days in BS year
     */
    protected array $yearDaysCache = [];

    /**
     * Convert BS to AD
     */
    public function bsToAd(
        int $year,
        int $month,
        int $day
    ): EnglishDate {
        Validator::validateBS($year, $month, $day);

        $days = $this->totalBsDays($year, $month, $day);

        return new EnglishDate(
            Carbon::parse(self::AD_REFERENCE_DATE)
                ->addDays($days)
        );
    }

    /**
     * Convert AD to BS
     */
    public function adToBs(
        Carbon|string $date
    ): NepaliDateObject {

        $date = $date instanceof Carbon
            ? $date
            : Carbon::parse($date);

        $reference = Carbon::parse(
            self::AD_REFERENCE_DATE
        );

        $days = $reference->diffInDays(
            $date,
            false
        );

        if ($days < 0) {
            throw new InvalidArgumentException(
                'Date is before supported range.'
            );
        }

        $year = self::BS_REFERENCE_YEAR;
        $month = self::BS_REFERENCE_MONTH;
        $day = self::BS_REFERENCE_DAY;

        /*
         * Skip complete years
         */
        while ($days >= $this->yearDays($year)) {

            $days -= $this->yearDays($year);

            $year++;
        }

        /*
         * Skip complete months
         */
        while ($days >= CalendarData::monthDays($year, $month)) {

            $days -= CalendarData::monthDays(
                $year,
                $month
            );

            $month++;

            if ($month > 12) {

                $month = 1;
                $year++;
            }
        }

        /*
         * Remaining days
         */
        $day += $days;

        return new NepaliDateObject(
            $year,
            $month,
            $day
        );
    }

    /**
     * Count days from BS reference date
     */
    private function totalBsDays(
        int $year,
        int $month,
        int $day
    ): int {

        $total = 0;

        /*
         * Previous years
         */
        for (
            $y = self::BS_REFERENCE_YEAR;
            $y < $year;
            $y++
        ) {

            $total += $this->yearDays($y);
        }

        /*
         * Previous months
         */
        for ($m = 1; $m < $month; $m++) {

            $total += CalendarData::monthDays(
                $year,
                $m
            );
        }

        /*
         * Current month
         */
        return $total + ($day - 1);
    }

    /**
     * Total days in BS year
     */
    private function yearDays(
        int $year
    ): int {

        if (! isset($this->yearDaysCache[$year])) {

            $this->yearDaysCache[$year] = array_sum(
                CalendarData::year($year)
            );
        }

        return $this->yearDaysCache[$year];
    }
}

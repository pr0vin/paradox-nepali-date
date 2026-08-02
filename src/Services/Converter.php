<?php

namespace Paradox\NepaliDate\Services;

use Carbon\Carbon;
use Paradox\NepaliDate\Objects\NepaliDate as NepaliDateObject;
use Paradox\NepaliDate\Data\CalendarData;
use Paradox\NepaliDate\Support\Validator;

class Converter
{
    private const BS_REFERENCE_YEAR = 2000;
    private const AD_REFERENCE_DATE = '1943-04-14';


    /**
     * BS -> AD
     */
    public function bsToAd(
        int $year,
        int $month,
        int $day
    ): Carbon {

        // Validator::validateBS($year, $month, $day);

        $totalDays = $this->totalBsDays(
            $year,
            $month,
            $day
        );

        return Carbon::parse(
            self::AD_REFERENCE_DATE
        )->addDays($totalDays);
    }



    /**
     * AD -> BS
     */
    public function adToBs(string $date): NepaliDateObject
    {
        $date = Carbon::parse($date);

        $reference = Carbon::parse(
            self::AD_REFERENCE_DATE
        );

        $totalDays = $reference->diffInDays($date);

        $year = self::BS_REFERENCE_YEAR;
        $month = 1;
        $day = 1;

        while ($totalDays > 0) {

            $monthDays = CalendarData::monthDays(
                $year,
                $month
            );

            $day++;

            if ($day > $monthDays) {
                $day = 1;
                $month++;
            }

            if ($month > 12) {
                $month = 1;
                $year++;
            }

            $totalDays--;
        }

        return new NepaliDateObject(
            $year,
            $month,
            $day
        );
    }



    /**
     * Count BS days from 2000-01-01
     */
    private function totalBsDays(
        int $year,
        int $month,
        int $day
    ): int {

        $total = 0;


        // years
        for (
            $y = self::BS_REFERENCE_YEAR;
            $y < $year;
            $y++
        ) {

            for ($m = 1; $m <= 12; $m++) {

                $total += CalendarData::monthDays(
                    $y,
                    $m
                );
            }
        }


        // months
        for (
            $m = 1;
            $m < $month;
            $m++
        ) {

            $total += CalendarData::monthDays(
                $year,
                $m
            );
        }


        // days

        $total += $day - 1;


        return $total;
    }




    /**
     * AD leap year
     */
    public function isLeapYear(int $year): bool
    {

        return (
            $year % 400 === 0 ||
            ($year % 4 === 0 &&
                $year % 100 !== 0)
        );
    }



    /**
     * Days in AD month
     */
    private function adMonthDays(
        int $year,
        int $month
    ): int {

        $months = [
            1 => 31,
            2 => $this->isLeapYear($year) ? 29 : 28,
            3 => 31,
            4 => 30,
            5 => 31,
            6 => 30,
            7 => 31,
            8 => 31,
            9 => 30,
            10 => 31,
            11 => 30,
            12 => 31,
        ];


        return $months[$month];
    }
}

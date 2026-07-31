<?php

namespace Paradox\NepaliDate\Services;

use Carbon\Carbon;
use Paradox\NepaliDate\Data\CalendarData;
use Paradox\NepaliDate\Support\Validator;

class Converter
{
    /**
     * Convert BS to AD
     */
    public function bsToAd(int $year, int $month, int $day): Carbon
    {
        // Validator::validateBS($year, $month, $day);

        $days = $this->totalDaysFromReference($year, $month, $day);

        return Carbon::create(1943, 4, 14)->addDays($days);
    }

    /**
     * Count total days from BS 2000/01/01
     */
    private function totalDaysFromReference(
        int $year,
        int $month,
        int $day
    ): int {

        $total = 0;

        /*
         |-----------------------------------------
         | Count complete years
         |-----------------------------------------
         */
        for ($y = 2000; $y < $year; $y++) {

            for ($m = 1; $m <= 12; $m++) {
                $total += CalendarData::monthDays($y, $m);
            }
        }

        /*
         |-----------------------------------------
         | Count complete months
         |-----------------------------------------
         */
        for ($m = 1; $m < $month; $m++) {
            $total += CalendarData::monthDays($year, $m);
        }

        /*
         |-----------------------------------------
         | Count days
         |-----------------------------------------
         */

        $total += ($day - 1);

        return $total;
    }
}

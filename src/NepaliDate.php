<?php

namespace Paradox\NepaliDate;

use Carbon\Carbon;
use Paradox\NepaliDate\Data\CalendarData;
use Paradox\NepaliDate\Objects\NepaliDate as NepaliDateObject;
use Paradox\NepaliDate\Services\Converter;

class NepaliDate
{
    protected Converter $converter;

    public function __construct()
    {
        $this->converter = new Converter();
    }

    public function parse(string $adDate): NepaliDateObject
    {
        return $this->converter->adToBs($adDate);
    }

    public function today(): NepaliDateObject
    {
        return $this->parse(
            Carbon::today()->format('Y-m-d')
        );
    }

    public function now(): NepaliDateObject
    {
        return $this->parse(
            Carbon::now()->format('Y-m-d')
        );
    }

    public function create(
        int $year,
        int $month,
        int $day
    ): NepaliDateObject {
        return new NepaliDateObject(
            $year,
            $month,
            $day
        );
    }

    public function daysInMonth(
        int $year,
        int $month
    ): int {
        return CalendarData::monthDays(
            $year,
            $month
        );
    }

    public function monthName(int $month): string
    {
        return \Paradox\NepaliDate\Data\NepaliMonth::name($month);
    }

    public function weekName(int $day): string
    {
        return \Paradox\NepaliDate\Data\NepaliWeekDay::name($day);
    }

    public function shortWeek(int $day): string
    {
        return \Paradox\NepaliDate\Data\NepaliWeekDay::short($day);
    }

    public function adToBs(string $date): NepaliDateObject
    {
        return $this->parse($date);
    }

    public function bsToAd(
        int $year,
        int $month,
        int $day
    ): Carbon {
        return $this->converter->bsToAd(
            $year,
            $month,
            $day
        );
    }
}

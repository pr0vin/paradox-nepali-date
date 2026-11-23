<?php

namespace Paradox\NepaliDate;

use Carbon\Carbon;
use Paradox\NepaliDate\Data\CalendarData;
use Paradox\NepaliDate\Data\NepaliMonth;
use Paradox\NepaliDate\Data\NepaliWeekDay;
use Paradox\NepaliDate\Objects\EnglishDate;
use Paradox\NepaliDate\Objects\NepaliDate as NepaliDateObject;
use Paradox\NepaliDate\Services\Converter;
use Paradox\NepaliDate\Support\Validator;

class NepaliDate
{
    public function __construct(
        protected Converter $converter
    ) {}

    public function parse(Carbon|string $adDate): NepaliDateObject
    {
        return $this->converter->adToBs($adDate);
    }

    public function today(): NepaliDateObject
    {
        return $this->parse(Carbon::today());
    }

    public function now(): NepaliDateObject
    {
        return $this->parse(Carbon::now());
    }

    public function create(
        int $year,
        int $month,
        int $day
    ): NepaliDateObject {
        Validator::validateBS($year, $month, $day);

        return new NepaliDateObject($year, $month, $day);
    }

    public function daysInMonth(int $year, int $month): int
    {
        return CalendarData::monthDays($year, $month);
    }

    public function monthName(int $month): string
    {
        return NepaliMonth::name($month);
    }

    public function weekName(int $day): string
    {
        return NepaliWeekDay::name($day);
    }

    public function shortWeek(int $day): string
    {
        return NepaliWeekDay::short($day);
    }

    public function adToBs(Carbon|string $date): NepaliDateObject
    {
        return $this->converter->adToBs($date);
    }

    public function bsToAd(
        int $year,
        int $month,
        int $day
    ): EnglishDate {
        return $this->converter->bsToAd($year, $month, $day);
    }
}

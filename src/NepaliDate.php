<?php

namespace Paradox\NepaliDate;

use Carbon\Carbon;
use Paradox\NepaliDate\Objects\NepaliDateObject;
use Paradox\NepaliDate\Services\Converter;

class NepaliDate
{
    public static function parse(string $date): NepaliDateObject
    {
        return (new Converter())->adToBs($date);
    }

    public static function today(): NepaliDateObject
    {
        return self::parse(
            Carbon::today()->toDateString()
        );
    }

    public static function now(): NepaliDateObject
    {
        return self::today();
    }

    public static function bs(
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
}

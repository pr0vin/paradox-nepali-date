<?php

namespace Paradox\NepaliDate\Objects;

use Carbon\Carbon;
use Paradox\NepaliDate\Data\NepaliMonth;
use Paradox\NepaliDate\Data\NepaliWeekDay;
use Paradox\NepaliDate\Services\Converter;

class NepaliDateObject
{
    public function __construct(
        protected int $year,
        protected int $month,
        protected int $day
    ) {}

    public function year(): int
    {
        return $this->year;
    }

    public function month(): int
    {
        return $this->month;
    }

    public function day(): int
    {
        return $this->day;
    }

    public function monthName(): string
    {
        return NepaliMonth::name($this->month);
    }

    public function weekName(): string
    {
        return NepaliWeekDay::name(
            $this->toCarbon()->dayOfWeekIso
        );
    }

    public function shortWeek(): string
    {
        return NepaliWeekDay::short(
            $this->toCarbon()->dayOfWeekIso
        );
    }

    public function format(string $separator = '-'): string
    {
        return sprintf(
            "%04d%s%02d%s%02d",
            $this->year,
            $separator,
            $this->month,
            $separator,
            $this->day
        );
    }

    public function readable(): string
    {
        return $this->day . ' '
            . $this->monthName()
            . ' '
            . $this->year;
    }

    public function toCarbon(): Carbon
    {
        return (new Converter())->bsToAd(
            $this->year,
            $this->month,
            $this->day
        );
    }

    public function toArray(): array
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'month_name' => $this->monthName(),
            'week_name' => $this->weekName(),
            'short_week' => $this->shortWeek(),
        ];
    }

    public function __toString(): string
    {
        return $this->format();
    }
}

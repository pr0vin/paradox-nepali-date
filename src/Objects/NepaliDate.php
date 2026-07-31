<?php

namespace Paradox\NepaliDate\Objects;

use Paradox\NepaliDate\Data\NepaliMonth;
use Paradox\NepaliDate\Data\NepaliWeekDay;

class NepaliDate
{
    public function __construct(
        public int $year,
        public int $month,
        public int $day,
        public ?int $weekDay = null
    ) {}


    /**
     * Create NepaliDate from converter array
     */
    public static function make(array $date): static
    {
        return new static(
            year: $date['year'],
            month: $date['month'],
            day: $date['day'],
            weekDay: $date['week_day'] ?? null
        );
    }


    /**
     * Get BS year
     */
    public function year(): int
    {
        return $this->year;
    }


    /**
     * Get BS month number
     */
    public function month(): int
    {
        return $this->month;
    }


    /**
     * Get BS day
     */
    public function day(): int
    {
        return $this->day;
    }


    /**
     * Full month name
     */
    public function monthName(): string
    {
        return NepaliMonth::name($this->month);
    }


    /**
     * Week day name
     */
    public function weekName(): ?string
    {
        if (!$this->weekDay) {
            return null;
        }

        return NepaliWeekDay::name($this->weekDay);
    }


    /**
     * Short week day
     */
    public function shortWeek(): ?string
    {
        if (!$this->weekDay) {
            return null;
        }

        return NepaliWeekDay::short($this->weekDay);
    }


    /**
     * Format date
     */
    public function format(string $separator = '-'): string
    {
        return $this->year
            . $separator
            . str_pad($this->month, 2, '0', STR_PAD_LEFT)
            . $separator
            . str_pad($this->day, 2, '0', STR_PAD_LEFT);
    }


    /**
     * Readable date
     */
    public function readable(): string
    {
        return $this->day . ' ' . $this->monthName() . ' ' . $this->year;
    }


    /**
     * Convert to array
     */
    public function toArray(): array
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'month_name' => $this->monthName(),
            'day' => $this->day,
            'week' => $this->weekName(),
            'short_week' => $this->shortWeek(),
        ];
    }


    /**
     * String conversion
     */
    public function __toString(): string
    {
        return $this->format();
    }
}

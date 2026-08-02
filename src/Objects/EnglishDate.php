<?php

namespace Paradox\NepaliDate\Objects;

use Carbon\Carbon;
use JsonSerializable;
use Paradox\NepaliDate\Services\Converter;

class EnglishDate implements JsonSerializable
{
    /**
     * Carbon instance.
     */
    protected Carbon $date;

    /**
     * Cached Nepali date.
     */
    protected ?NepaliDate $nepaliDate = null;

    public function __construct(
        Carbon|string $date
    ) {
        $this->date = $date instanceof Carbon
            ? $date
            : Carbon::parse($date);
    }

    /**
     * Create from year, month, day.
     */
    public static function make(
        int $year,
        int $month,
        int $day
    ): self {

        return new self(
            Carbon::create(
                $year,
                $month,
                $day
            )
        );
    }

    /**
     * Year.
     */
    public function year(): int
    {
        return $this->date->year;
    }

    /**
     * Month.
     */
    public function month(): int
    {
        return $this->date->month;
    }

    /**
     * Day.
     */
    public function day(): int
    {
        return $this->date->day;
    }

    /**
     * Hour.
     */
    public function hour(): int
    {
        return $this->date->hour;
    }

    /**
     * Minute.
     */
    public function minute(): int
    {
        return $this->date->minute;
    }

    /**
     * Second.
     */
    public function second(): int
    {
        return $this->date->second;
    }

    /**
     * Month name.
     */
    public function monthName(): string
    {
        return $this->date->format('F');
    }

    /**
     * Short month name.
     */
    public function shortMonth(): string
    {
        return $this->date->format('M');
    }

    /**
     * Week day name.
     */
    public function weekName(): string
    {
        return $this->date->format('l');
    }

    /**
     * Short week day.
     */
    public function shortWeek(): string
    {
        return $this->date->format('D');
    }

    /**
     * Day of week.
     */
    public function dayOfWeek(): int
    {
        return $this->date->dayOfWeek;
    }

    /**
     * ISO day of week.
     */
    public function dayOfWeekIso(): int
    {
        return $this->date->dayOfWeekIso;
    }

    /**
     * Leap year.
     */
    public function isLeapYear(): bool
    {
        return $this->date->isLeapYear();
    }

    /**
     * Weekend.
     */
    public function isWeekend(): bool
    {
        return $this->date->isWeekend();
    }

    /**
     * Weekday.
     */
    public function isWeekday(): bool
    {
        return $this->date->isWeekday();
    }

    /**
     * Format.
     */
    public function format(
        string $format = 'Y-m-d'
    ): string {

        return $this->date->format($format);
    }

    /**
     * Human readable.
     */
    public function readable(): string
    {
        return $this->format('d F Y');
    }

    /**
     * Convert to Nepali.
     */
    public function toNepali(): NepaliDate
    {
        if ($this->nepaliDate === null) {

            $this->nepaliDate = app(Converter::class)
                ->adToBs($this->date);
        }

        return $this->nepaliDate;
    }

    /**
     * Carbon instance.
     */
    public function toCarbon(): Carbon
    {
        return $this->date->copy();
    }

    /**
     * Array.
     */
    public function toArray(): array
    {
        return [
            'year' => $this->year(),
            'month' => $this->month(),
            'day' => $this->day(),
            'formatted' => $this->format(),
            'readable' => $this->readable(),
            'month_name' => $this->monthName(),
            'short_month' => $this->shortMonth(),
            'week_name' => $this->weekName(),
            'short_week' => $this->shortWeek(),
            'is_leap_year' => $this->isLeapYear(),
            'is_weekend' => $this->isWeekend(),
            'bs_date' => $this->toNepali()->format(),
        ];
    }

    /**
     * JSON.
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * String.
     */
    public function __toString(): string
    {
        return $this->format();
    }
}

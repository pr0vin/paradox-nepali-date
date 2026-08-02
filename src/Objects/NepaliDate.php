<?php

namespace Paradox\NepaliDate\Objects;

use Carbon\Carbon;
use JsonSerializable;
use Paradox\NepaliDate\Support\Formatter;
use Paradox\NepaliDate\Services\Converter;
use Paradox\NepaliDate\Objects\EnglishDate;

class NepaliDate implements JsonSerializable
{
    protected ?EnglishDate $englishDate = null;

    public function __construct(
        protected int $year,
        protected int $month,
        protected int $day
    ) {}

    /**
     * Get year.
     */
    public function year(): int
    {
        return $this->year;
    }

    /**
     * Get month.
     */
    public function month(): int
    {
        return $this->month;
    }

    /**
     * Get day.
     */
    public function day(): int
    {
        return $this->day;
    }

    /**
     * Month name.
     */
    public function monthName(): string
    {
        return Formatter::month($this->month);
    }
    /**
     * Day of week (0-6).
     */
    public function dayOfWeek(): int
    {
        return $this->toCarbon()->dayOfWeek;
    }

    /**
     * ISO day of week (1-7).
     */
    public function dayOfWeekIso(): int
    {
        return $this->toCarbon()->dayOfWeekIso;
    }

    /**
     * Week day name.
     */
    public function weekName(): string
    {
        return Formatter::week(
            $this->dayOfWeekIso()
        );
    }

    /**
     * Short week day.
     */
    public function shortWeek(): string
    {
        return Formatter::shortWeek(
            $this->dayOfWeekIso()
        );
    }

    /**
     * Format date.
     */
    public function format(
        string $separator = '-'
    ): string {

        return sprintf(
            '%04d%s%02d%s%02d',
            $this->year,
            $separator,
            $this->month,
            $separator,
            $this->day
        );
    }

    /**
     * Human readable.
     */
    public function readable(): string
    {
        return sprintf(
            '%d %s %d',
            $this->day,
            $this->monthName(),
            $this->year
        );
    }

    /**
     * Convert to Carbon.
     */
    /**
     * Convert to EnglishDate.
     */
    public function toEnglish(): EnglishDate
    {
        if ($this->englishDate === null) {

            $this->englishDate = app(Converter::class)
                ->bsToAd(
                    $this->year,
                    $this->month,
                    $this->day
                );
        }

        return $this->englishDate;
    }

    /**
     * Convert to Carbon.
     */
    public function toCarbon(): Carbon
    {
        return $this->toEnglish()->toCarbon();
    }
    /**
     * Convert to array.
     */
    public function toArray(): array
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'formatted' => $this->format(),
            'readable' => $this->readable(),
            'month_name' => $this->monthName(),
            'week_name' => $this->weekName(),
            'short_week' => $this->shortWeek(),
            'ad_date' => $this->toCarbon()->toDateString(),
        ];
    }

    /**
     * JSON serialization.
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * String representation.
     */
    public function __toString(): string
    {
        return $this->format();
    }
}

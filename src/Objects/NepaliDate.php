<?php

namespace Paradox\NepaliDate\Objects;

use Carbon\Carbon;
use JsonSerializable;
use Paradox\NepaliDate\Support\Formatter;
use Paradox\NepaliDate\Services\Converter;
use Paradox\NepaliDate\Objects\EnglishDate;
use Paradox\NepaliDate\Data\CalendarData;
use Paradox\NepaliDate\Support\Validator;

class NepaliDate implements JsonSerializable
{
    protected int $year;
    protected int $month;
    protected int $day;
    protected ?EnglishDate $englishDate = null;

    public function __construct(
        ?int $year = null,
        ?int $month = null,
        ?int $day = null
    ) {
        if ($year === null && $month === null && $day === null) {
            $today = app(Converter::class)->adToBs(Carbon::today());

            $this->year = $today->year();
            $this->month = $today->month();
            $this->day = $today->day();

            return;
        }

        if ($year === null || $month === null || $day === null) {
            throw new \InvalidArgumentException(
                'Year, month and day must all be provided.'
            );
        }

        Validator::validateBS($year, $month, $day);

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }


    /**
     * Get today's Nepali date.
     */
    public static function today(): self
    {
        return new self();
    }

    /**
     * Get current Nepali date.
     */
    public static function now(): self
    {
        return new self();
    }

    /**
     * Create Nepali date from English date.
     */
    public static function fromEnglish(Carbon|string $date): self
    {
        $converted = app(Converter::class)->adToBs($date);

        return new self(
            $converted->year(),
            $converted->month(),
            $converted->day()
        );
    }
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
     * Human readable date.
     *
     * @param string|null $week long, short or null
     */
    public function readable(?string $week = null): string
    {
        $date = sprintf(
            '%s %s %s',
            toNepaliNumber($this->year),
            $this->monthName(),
            toNepaliNumber($this->day)
        );

        $weekName = match ($week) {
            'l' => $this->weekName(),
            's' => $this->shortWeek(),
            null => null,
            default => throw new \InvalidArgumentException(
                'Week format must be long, short or null.'
            ),
        };

        return $weekName
            ? $date . 'गते' . ', ' . $weekName
            : $date;
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
            'week' => $this->dayOfWeekIso(),
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
    public function jsonSerialize(): array
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

    public function dayOfWeek(): int
    {
        return $this->toCarbon()->dayOfWeek;
    }
    /**
     * Add days.
     */
    public function addDays(int $days): self
    {
        $ad = $this->toCarbon()
            ->copy()
            ->addDays($days)
            ->toDateString();

        return app(Converter::class)->adToBs($ad);
    }

    public function subDays(int $days): self
    {
        return $this->addDays(-$days);
    }

    public function addDay(): self
    {
        return $this->addDays(1);
    }

    public function subDay(): self
    {
        return $this->subDays(1);
    }

    /**
     * Add months.
     */

    public function addMonths(int $months): self
    {
        $totalMonths = ($this->year * 12)
            + ($this->month - 1)
            + $months;

        $year = intdiv($totalMonths, 12);
        $month = ($totalMonths % 12) + 1;

        $maxDays = CalendarData::monthDays($year, $month);
        $day = min($this->day, $maxDays);

        return new self($year, $month, $day);
    }

    public function subMonths(int $months): self
    {
        return $this->addMonths(-$months);
    }

    public function addMonth(): self
    {
        return $this->addMonths(1);
    }

    public function subMonth(): self
    {
        return $this->subMonths(1);
    }

    public function addYears(int $years): self
    {
        $year = $this->year + $years;

        $maxDays = CalendarData::monthDays($year, $this->month);
        $day = min($this->day, $maxDays);

        return new self($year, $this->month, $day);
    }

    public function subYears(int $years): self
    {
        return $this->addYears(-$years);
    }

    public function addYear(): self
    {
        return $this->addYears(1);
    }

    public function subYear(): self
    {
        return $this->subYears(1);
    }

    /**
     * Check if dates are equal.
     */
    public function equals(NepaliDate $other): bool
    {
        return $this->toCarbon()->isSameDay(
            $other->toCarbon()
        );
    }


    /**
     * Check if this date is before another date.
     */
    public function isBefore(NepaliDate $other): bool
    {
        return $this->toCarbon()->lt(
            $other->toCarbon()
        );
    }


    /**
     * Check if this date is after another date.
     */
    public function isAfter(NepaliDate $other): bool
    {
        return $this->toCarbon()->gt(
            $other->toCarbon()
        );
    }


    /**
     * Check if date is between two dates.
     */
    public function between(
        NepaliDate $start,
        NepaliDate $end,
        bool $inclusive = true
    ): bool {

        return $this->toCarbon()->between(
            $start->toCarbon(),
            $end->toCarbon(),
            $inclusive
        );
    }


    /**
     * Difference in days.
     */
    public function diffInDays(
        NepaliDate $other,
        bool $absolute = true
    ): int {
        return (int) $this->toCarbon()->diffInDays(
            $other->toCarbon(),
            $absolute
        );
    }
}

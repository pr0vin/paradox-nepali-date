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
    /**
     * Add days.
     */
    public function addDays(int $days): self
    {
        $ad = $this->toCarbon()->copy()->addDays($days);

        return app(Converter::class)
            ->adToBs($ad->toDateString());
    }

    /**
     * Subtract days.
     */
    public function subDays(int $days): self
    {
        return $this->addDays(-$days);
    }

    /**
     * Add one day.
     */
    public function addDay(): self
    {
        return $this->addDays(1);
    }

    /**
     * Subtract one day.
     */
    public function subDay(): self
    {
        return $this->subDays(1);
    }

    /**
     * Add months.
     */
    public function addMonths(int $months): self
    {
        $ad = $this->toCarbon()->copy()->addMonths($months);

        return app(Converter::class)
            ->adToBs($ad->toDateString());
    }

    /**
     * Subtract months.
     */
    public function subMonths(int $months): self
    {
        return $this->addMonths(-$months);
    }

    /**
     * Add one month.
     */
    public function addMonth(): self
    {
        return $this->addMonths(1);
    }

    /**
     * Subtract one month.
     */
    public function subMonth(): self
    {
        return $this->subMonths(1);
    }

    /**
     * Add years.
     */
    public function addYears(int $years): self
    {
        $ad = $this->toCarbon()->copy()->addYears($years);

        return app(Converter::class)
            ->adToBs($ad->toDateString());
    }

    /**
     * Subtract years.
     */
    public function subYears(int $years): self
    {
        return $this->addYears(-$years);
    }

    /**
     * Add one year.
     */
    public function addYear(): self
    {
        return $this->addYears(1);
    }

    /**
     * Subtract one year.
     */
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

        return $this->toCarbon()->diffInDays(
            $other->toCarbon(),
            $absolute
        );
    }
}

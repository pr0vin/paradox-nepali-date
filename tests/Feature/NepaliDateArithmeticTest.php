<?php

namespace Paradox\NepaliDate\Tests\Feature;

use Paradox\NepaliDate\NepaliDate;
use Paradox\NepaliDate\Objects\NepaliDate as NepaliDateObject;
use Paradox\NepaliDate\Tests\TestCase;

class NepaliDateArithmeticTest extends TestCase
{
    protected NepaliDate $nepaliDate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->nepaliDate = $this->app->make(NepaliDate::class);
    }

    public function test_add_day(): void
    {
        $date = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $result = $date->addDay();

        $this->assertSame(2000, $result->year());
        $this->assertSame(1, $result->month());
        $this->assertSame(2, $result->day());
    }

    public function test_sub_day(): void
    {
        $date = $this->nepaliDate->create(
            2000,
            1,
            2
        );

        $result = $date->subDay();

        $this->assertSame(2000, $result->year());
        $this->assertSame(1, $result->month());
        $this->assertSame(1, $result->day());
    }

    public function test_add_days(): void
    {
        $date = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $result = $date->addDays(10);

        $this->assertInstanceOf(
            NepaliDateObject::class,
            $result
        );

        $this->assertSame(
            '1943-04-24',
            $result->toCarbon()->toDateString()
        );
    }

    public function test_sub_days(): void
    {
        $date = $this->nepaliDate->create(
            2000,
            1,
            10
        );

        $result = $date->subDays(5);

        $this->assertSame(
            '1943-04-18',
            $result->toCarbon()->toDateString()
        );
    }

    public function test_add_and_subtract_day_are_inverse_operations(): void
    {
        $date = $this->nepaliDate->create(
            2000,
            1,
            10
        );

        $result = $date
            ->addDay()
            ->subDay();

        $this->assertTrue(
            $result->equals($date)
        );
    }

    public function test_add_year_changes_year(): void
    {
        $date = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $result = $date->addYear();

        $this->assertSame(
            '1944-04-14',
            $result->toCarbon()->toDateString()
        );
    }

    public function test_comparison_equals(): void
    {
        $first = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $second = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $this->assertTrue(
            $first->equals($second)
        );
    }

    public function test_is_before(): void
    {
        $first = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $second = $this->nepaliDate->create(
            2000,
            1,
            2
        );

        $this->assertTrue(
            $first->isBefore($second)
        );
    }

    public function test_is_after(): void
    {
        $first = $this->nepaliDate->create(
            2000,
            1,
            2
        );

        $second = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $this->assertTrue(
            $first->isAfter($second)
        );
    }

    public function test_diff_in_days(): void
    {
        $first = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $second = $this->nepaliDate->create(
            2000,
            1,
            11
        );

        $this->assertSame(
            10,
            $first->diffInDays($second)
        );
    }
}

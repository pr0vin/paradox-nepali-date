<?php

namespace Paradox\NepaliDate\Tests\Feature;

use Carbon\Carbon;
use Paradox\NepaliDate\NepaliDate;
use Paradox\NepaliDate\Objects\EnglishDate;
use Paradox\NepaliDate\Objects\NepaliDate as NepaliDateObject;
use Paradox\NepaliDate\Tests\TestCase;

class NepaliDateTest extends TestCase
{
    protected NepaliDate $nepaliDate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->nepaliDate = $this->app->make(NepaliDate::class);
    }

    public function test_parse_returns_nepali_date(): void
    {
        $result = $this->nepaliDate->parse('1943-04-14');

        $this->assertInstanceOf(
            NepaliDateObject::class,
            $result
        );
    }

    public function test_reference_date_is_converted_correctly(): void
    {
        $result = $this->nepaliDate->parse('1943-04-14');

        $this->assertSame(2000, $result->year());
        $this->assertSame(1, $result->month());
        $this->assertSame(1, $result->day());
    }

    public function test_create_returns_correct_date(): void
    {
        $result = $this->nepaliDate->create(
            2083,
            4,
            15
        );

        $this->assertInstanceOf(
            NepaliDateObject::class,
            $result
        );

        $this->assertSame(2083, $result->year());
        $this->assertSame(4, $result->month());
        $this->assertSame(15, $result->day());
    }

    public function test_date_can_be_formatted(): void
    {
        $result = $this->nepaliDate->create(
            2083,
            4,
            15
        );

        $this->assertSame(
            '2083-04-15',
            $result->format()
        );
    }

    public function test_date_can_be_formatted_with_custom_separator(): void
    {
        $result = $this->nepaliDate->create(
            2083,
            4,
            15
        );

        $this->assertSame(
            '2083/04/15',
            $result->format('/')
        );
    }

    public function test_date_can_be_converted_to_string(): void
    {
        $result = $this->nepaliDate->create(
            2083,
            4,
            15
        );

        $this->assertSame(
            '2083-04-15',
            (string) $result
        );
    }

    public function test_days_in_month_returns_valid_number(): void
    {
        $days = $this->nepaliDate->daysInMonth(
            2083,
            4
        );

        $this->assertIsInt($days);
        $this->assertGreaterThan(0, $days);
    }

    public function test_month_name_returns_string(): void
    {
        $result = $this->nepaliDate->monthName(1);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    public function test_week_name_returns_string(): void
    {
        $result = $this->nepaliDate->weekName(1);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    public function test_short_week_returns_string(): void
    {
        $result = $this->nepaliDate->shortWeek(1);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    public function test_ad_to_bs_returns_nepali_date(): void
    {
        $result = $this->nepaliDate->adToBs(
            '1943-04-14'
        );

        $this->assertInstanceOf(
            NepaliDateObject::class,
            $result
        );

        $this->assertSame(2000, $result->year());
        $this->assertSame(1, $result->month());
        $this->assertSame(1, $result->day());
    }

    public function test_bs_to_ad_returns_english_date(): void
    {
        $result = $this->nepaliDate->bsToAd(
            2000,
            1,
            1
        );

        $this->assertInstanceOf(
            EnglishDate::class,
            $result
        );
    }

    public function test_reference_date_converts_to_correct_carbon_date(): void
    {
        $result = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $this->assertInstanceOf(
            Carbon::class,
            $result->toCarbon()
        );

        $this->assertSame(
            '1943-04-14',
            $result->toCarbon()->toDateString()
        );
    }

    public function test_to_array_contains_expected_keys(): void
    {
        $result = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $array = $result->toArray();

        $this->assertArrayHasKey('year', $array);
        $this->assertArrayHasKey('month', $array);
        $this->assertArrayHasKey('day', $array);
        $this->assertArrayHasKey('formatted', $array);
        $this->assertArrayHasKey('readable', $array);
        $this->assertArrayHasKey('month_name', $array);
        $this->assertArrayHasKey('week_name', $array);
        $this->assertArrayHasKey('short_week', $array);
        $this->assertArrayHasKey('ad_date', $array);
    }

    public function test_json_serialization_works(): void
    {
        $result = $this->nepaliDate->create(
            2000,
            1,
            1
        );

        $json = json_encode($result);

        $this->assertIsString($json);
        $this->assertNotFalse($json);

        $this->assertSame(
            '2000-01-01',
            json_decode($json)
        );
    }
}

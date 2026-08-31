<?php

namespace Paradox\NepaliDate\Tests\Unit;

use Carbon\Carbon;
use InvalidArgumentException;
use Paradox\NepaliDate\Objects\EnglishDate;
use Paradox\NepaliDate\Objects\NepaliDate;
use Paradox\NepaliDate\Services\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    protected Converter $converter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->converter = new Converter();
    }

    public function test_reference_bs_date_converts_to_reference_ad_date(): void
    {
        $result = $this->converter->bsToAd(2000, 1, 1);

        $this->assertInstanceOf(
            EnglishDate::class,
            $result
        );

        $this->assertEquals(
            '1943-04-14',
            $result->toCarbon()->format('Y-m-d')
        );
    }

    public function test_reference_ad_date_converts_to_reference_bs_date(): void
    {
        $result = $this->converter->adToBs('1943-04-14');

        $this->assertInstanceOf(
            NepaliDate::class,
            $result
        );

        $this->assertSame(2000, $result->year());
        $this->assertSame(1, $result->month());
        $this->assertSame(1, $result->day());
    }

    public function test_ad_date_can_be_passed_as_carbon_instance(): void
    {
        $date = Carbon::parse('1943-04-14');

        $result = $this->converter->adToBs($date);

        $this->assertSame(2000, $result->year());
        $this->assertSame(1, $result->month());
        $this->assertSame(1, $result->day());
    }

    public function test_date_one_day_after_reference_date(): void
    {
        $result = $this->converter->adToBs('1943-04-15');

        $this->assertSame(2000, $result->year());
        $this->assertSame(1, $result->month());
        $this->assertSame(2, $result->day());
    }

    public function test_date_before_supported_range_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->converter->adToBs('1943-04-13');
    }

    public function test_bs_to_ad_returns_english_date_object(): void
    {
        $result = $this->converter->bsToAd(2000, 1, 1);

        $this->assertInstanceOf(
            EnglishDate::class,
            $result
        );
    }

    public function test_ad_to_bs_returns_nepali_date_object(): void
    {
        $result = $this->converter->adToBs('1943-04-14');

        $this->assertInstanceOf(
            NepaliDate::class,
            $result
        );
    }
}

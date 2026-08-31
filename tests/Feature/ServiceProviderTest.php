<?php

namespace Paradox\NepaliDate\Tests\Feature;

use Paradox\NepaliDate\NepaliDate;
use Paradox\NepaliDate\Services\Converter;
use Paradox\NepaliDate\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_converter_can_be_resolved(): void
    {
        $converter = $this->app->make(Converter::class);

        $this->assertInstanceOf(
            Converter::class,
            $converter
        );
    }

    public function test_nepali_date_can_be_resolved(): void
    {
        $nepaliDate = $this->app->make(NepaliDate::class);

        $this->assertInstanceOf(
            NepaliDate::class,
            $nepaliDate
        );
    }

    public function test_converter_is_singleton(): void
    {
        $first = $this->app->make(Converter::class);
        $second = $this->app->make(Converter::class);

        $this->assertSame($first, $second);
    }

    public function test_nepali_date_is_singleton(): void
    {
        $first = $this->app->make(NepaliDate::class);
        $second = $this->app->make(NepaliDate::class);

        $this->assertSame($first, $second);
    }

    public function test_nepali_date_alias_works(): void
    {
        $nepaliDate = $this->app->make('nepali-date');

        $this->assertInstanceOf(
            NepaliDate::class,
            $nepaliDate
        );
    }
}

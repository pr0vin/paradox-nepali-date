<?php

namespace Paradox\NepaliDate;

use Illuminate\Support\ServiceProvider;
use Paradox\NepaliDate\NepaliDate;
use Paradox\NepaliDate\Services\Converter;

class NepaliDateServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        $this->app->singleton(
            NepaliDate::class,
            function () {
                return new NepaliDate();
            }
        );


        $this->app->singleton(
            Converter::class,
            function () {
                return new Converter();
            }
        );


        // optional alias
        $this->app->alias(
            NepaliDate::class,
            'nepali-date'
        );
    }


    public function boot(): void
    {
        //
    }
}

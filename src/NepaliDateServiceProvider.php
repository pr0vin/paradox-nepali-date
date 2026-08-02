<?php

namespace Paradox\NepaliDate;

use Illuminate\Support\ServiceProvider;
use Paradox\NepaliDate\Services\Converter;

class NepaliDateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            Converter::class,
            fn() => new Converter()
        );


        $this->app->singleton(
            NepaliDate::class,
            function ($app) {

                return new NepaliDate(
                    $app->make(Converter::class)
                );
            }
        );


        // Facade binding
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

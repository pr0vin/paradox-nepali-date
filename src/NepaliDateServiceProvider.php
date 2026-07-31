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
    }

    public function boot(): void
    {
        //
    }
}

<?php

namespace Paradox\NepaliDate\Facades;

use Illuminate\Support\Facades\Facade;

class NepaliDate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'nepali-date';
    }
}

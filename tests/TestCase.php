<?php

namespace Paradox\NepaliDate\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Paradox\NepaliDate\NepaliDateServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            NepaliDateServiceProvider::class,
        ];
    }
}

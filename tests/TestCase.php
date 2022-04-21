<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Fixtures\ServiceProvider as FixtureServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            FixtureServiceProvider::class,
        ];
    }
}

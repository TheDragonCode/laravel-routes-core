<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\ExtendedTests\Assert;
use Tests\Fixtures\ServiceProvider as FixtureServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use Assert;

    protected function getPackageProviders($app): array
    {
        return [FixtureServiceProvider::class];
    }
}

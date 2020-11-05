<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $this->setRoutes($app);
    }

    protected function setRoutes($app)
    {
        $app['router']->get('/foo', function () {
        });

        $app['router']->match(['PUT', 'PATCH'], '/bar', function () {
        });

        $app['router']->get('/_ignition/baq', function () {
        });

        $app['router']->get('/telescope/baw', function () {
        });

        $app['router']->get('/_debugbar/bae', function () {
        });
    }
}

<?php

namespace Tests;

use Helldar\LaravelRoutesCore\Facades\Routes;

final class RoutesTest extends TestCase
{
    public function testStructure()
    {
        $routes = Routes::get();

        $this->assertTrue(true);
    }
}

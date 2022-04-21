<?php

namespace Tests;

use DragonCode\LaravelRoutesCore\Facades\Routes;
use DragonCode\LaravelRoutesCore\Models\Route;

class AnnotationsTest extends TestCase
{
    public function testSummary()
    {
        $route = $this->route('summary');

        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse justo.', $route->getSummary());
        $this->assertNull($route->getDescription());
        $this->assertFalse($route->getDeprecated());
    }

    public function testDescription()
    {
        $route = $this->route('description');

        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse justo.', $route->getSummary());

        $this->assertEquals(
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit.\n"
            . "Pellentesque lorem libero, ultricies ut nisl in, vestibulum egestas neque.\n"
            . 'Nulla facilisi. Aenean vitae justo bibendum, scelerisque arcu cursus, scelerisque sapien.',
            $route->getDescription()
        );

        $this->assertFalse($route->getDeprecated());
    }

    public function testDeprecated()
    {
        $route = $this->route('deprecated');

        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse justo.', $route->getSummary());

        $this->assertEquals(
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit.\n"
            . "Pellentesque lorem libero, ultricies ut nisl in, vestibulum egestas neque.\n"
            . 'Nulla facilisi. Aenean vitae justo bibendum, scelerisque arcu cursus, scelerisque sapien.',
            $route->getDescription()
        );

        $this->assertTrue($route->getDeprecated());
    }

    public function testWithout()
    {
        $route = $this->route('without');

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertFalse($route->getDeprecated());
    }

    public function withoutDeprecated()
    {
        $route = $this->route('withoutDeprecated');

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertTrue($route->getDeprecated());
    }

    protected function route(string $name): Route
    {
        return Routes::collection()->filter(static fn (Route $route) => $name === $route->getName())->first();
    }
}

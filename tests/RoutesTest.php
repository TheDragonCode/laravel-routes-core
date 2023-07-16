<?php

namespace Tests;

use DragonCode\LaravelRoutesCore\Facades\Routes;
use DragonCode\LaravelRoutesCore\Models\Route;
use Illuminate\Support\Arr;
use Tests\Fixtures\Config;

class RoutesTest extends TestCase
{
    public function testStructure()
    {
        $routes = Routes::get();

        $this->assertIsArray($routes);

        foreach ($routes as $route) {
            $this->assertArrayHasKey('priority', $route);
            $this->assertIsInt(Arr::get($route, 'priority'));

            $this->assertArrayHasKey('methods', $route);
            $this->assertIsArray(Arr::get($route, 'methods'));

            $this->assertArrayHasKey('path', $route);
            $this->assertIsString(Arr::get($route, 'path'));

            $this->assertArrayHasKey('action', $route);
            $this->assertIsString(Arr::get($route, 'action'));

            $this->assertArrayHasKey('middlewares', $route);
            $this->assertIsArray(Arr::get($route, 'middlewares'));

            $this->assertArrayHasKey('exceptions', $route);
            $this->assertIsArray(Arr::get($route, 'exceptions'));

            $this->assertArrayHasKey('deprecated', $route);
            $this->assertIsBool(Arr::get($route, 'deprecated'));

            $this->assertArrayHasKey('is_api', $route);
            $this->assertIsBool(Arr::get($route, 'is_api'));

            $this->assertArrayHasKey('is_web', $route);
            $this->assertIsBool(Arr::get($route, 'is_web'));

            $this->assertArrayHasKey('domain', $route);
            $this->assertArrayHasKey('name', $route);
            $this->assertArrayHasKey('module', $route);
            $this->assertArrayHasKey('summary', $route);
            $this->assertArrayHasKey('description', $route);
            $this->assertArrayHasKey('response', $route);
        }
    }

    public function testMapping()
    {
        Routes::setApiMiddlewares(['api', 'foo'])
            ->setWebMiddlewares(['web', 'bar'])
            ->collection()
            ->each(function (Route $route) {
                switch ($route->getPath()) {
                    case 'foo':
                        $this->routeFoo($route);
                        break;
                    case 'bar':
                        $this->routeBar($route);
                        break;
                    case '_ignition/baq':
                        $this->routeIgnitionBaq($route);
                        break;
                    case 'telescope/baw':
                        $this->routeTelescopeBaw($route);
                        break;
                    case '_debugbar/bae':
                        $this->routeDebugBarBae($route);
                        break;
                    case 'summary':
                        $this->routeSummary($route);
                        break;
                    case 'description':
                        $this->routeDescription($route);
                        break;
                    case 'deprecated':
                        $this->routeDeprecated($route);
                        break;
                    case 'without':
                        $this->routeWithout($route);
                        break;
                    case 'withoutDeprecated':
                        $this->routeWithoutDeprecated($route);
                        break;
                    case 'incorrectDocBlock':
                        $this->routeIncorrectDocBlock($route);
                        break;
                    case 'routeApiMiddleware':
                        $this->routeRoutingApiMiddleware($route);
                        break;
                    case 'controllerApiMiddleware':
                        $this->routeControllerApiMiddleware($route);
                        break;
                    case 'routeWebMiddleware':
                        $this->routeRoutingWebMiddleware($route);
                        break;
                    case 'controllerWebMiddleware':
                        $this->routeControllerWebMiddleware($route);
                        break;
                    case 'closureNullName':
                        $this->routeClosureNullName($route);
                        break;
                    case 'closure':
                        $this->routeClosure($route);
                        break;

                    default:
                        $this->assertTrue(false);
                }
            });
    }

    public function testConfig()
    {
        $config = new Config();

        Routes::setFromConfig($config)
            ->collection()
            ->each(function (Route $route) {
                switch ($route->getPath()) {
                    case 'foo':
                        $this->routeFoo($route);
                        break;
                    case 'bar':
                        $this->routeBar($route);
                        break;
                    case '_ignition/baq':
                        $this->routeIgnitionBaq($route);
                        break;
                    case 'telescope/baw':
                        $this->routeTelescopeBaw($route);
                        break;
                    case '_debugbar/bae':
                        $this->routeDebugBarBae($route);
                        break;
                    case 'summary':
                        $this->routeSummary($route);
                        break;
                    case 'description':
                        $this->routeDescription($route);
                        break;
                    case 'deprecated':
                        $this->routeDeprecated($route);
                        break;
                    case 'without':
                        $this->routeWithout($route);
                        break;
                    case 'withoutDeprecated':
                        $this->routeWithoutDeprecated($route);
                        break;
                    case 'incorrectDocBlock':
                        $this->routeIncorrectDocBlock($route);
                        break;
                    case 'routeApiMiddleware':
                        $this->routeRoutingApiMiddleware($route);
                        break;
                    case 'controllerApiMiddleware':
                        $this->routeControllerApiMiddleware($route);
                        break;
                    case 'routeWebMiddleware':
                        $this->routeRoutingWebMiddleware($route);
                        break;
                    case 'controllerWebMiddleware':
                        $this->routeControllerWebMiddleware($route);
                        break;
                    case 'closureNullName':
                        $this->routeClosureNullName($route);
                        break;
                    case 'closure':
                        $this->routeClosure($route);
                        break;

                    default:
                        $this->assertTrue(false);
                }
            });
    }

    protected function routeFoo(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(1, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('foo', $route->getPath());

        $this->assertNull($route->getName());
        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Closure', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeBar(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(2, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['PUT', 'PATCH'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('bar', $route->getPath());

        $this->assertNull($route->getName());
        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Closure', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeIgnitionBaq(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(3, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('_ignition/baq', $route->getPath());

        $this->assertNull($route->getName());
        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Closure', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeTelescopeBaw(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(4, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('telescope/baw', $route->getPath());

        $this->assertNull($route->getName());
        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Closure', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeDebugBarBae(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(5, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('_debugbar/bae', $route->getPath());

        $this->assertNull($route->getName());
        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Closure', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeSummary(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(6, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('summary', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('summary', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Tests\Fixtures\Controller@summary', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertIsString($route->getSummary());
        $this->assertSame('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse justo.', $route->getSummary());

        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeDescription(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(7, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('description', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('description', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Tests\Fixtures\Controller@description', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertIsString($route->getSummary());
        $this->assertSame('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse justo.', $route->getSummary());

        $this->assertIsString($route->getDescription());
        $this->assertSame(
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit.\nPellentesque lorem libero, ultricies ut nisl in, vestibulum egestas neque.\nNulla facilisi. Aenean vitae justo bibendum, scelerisque arcu cursus, scelerisque sapien.",
            $route->getDescription()
        );

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeDeprecated(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(8, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('deprecated', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('deprecated', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Tests\Fixtures\Controller@deprecated', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertTrue($route->getDeprecated());

        $this->assertIsString($route->getSummary());
        $this->assertSame('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse justo.', $route->getSummary());

        $this->assertIsString($route->getDescription());
        $this->assertSame(
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit.\nPellentesque lorem libero, ultricies ut nisl in, vestibulum egestas neque.\nNulla facilisi. Aenean vitae justo bibendum, scelerisque arcu cursus, scelerisque sapien.",
            $route->getDescription()
        );

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeWithout(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(9, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('without', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('without', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Tests\Fixtures\Controller@without', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeWithoutDeprecated(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(10, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('withoutDeprecated', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('withoutDeprecated', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Tests\Fixtures\Controller@withoutDeprecated', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertTrue($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeIncorrectDocBlock(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(11, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('incorrectDocBlock', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('incorrectDocBlock', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Tests\Fixtures\Controller@incorrectDocBlock', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeRoutingApiMiddleware(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(12, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('routeApiMiddleware', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('routeApiMiddleware', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Tests\Fixtures\Controller@routeApiMiddleware', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame(['api'], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertTrue($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeControllerApiMiddleware(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(13, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('controllerApiMiddleware', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('controllerApiMiddleware', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Tests\Fixtures\Controller@controllerApiMiddleware', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame(['api'], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertTrue($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeRoutingWebMiddleware(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(14, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('routeWebMiddleware', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('routeWebMiddleware', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Tests\Fixtures\Controller@routeWebMiddleware', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame(['web'], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertNull($route->getSummary());

        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertTrue($route->isWeb());
    }

    protected function routeControllerWebMiddleware(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(15, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('controllerWebMiddleware', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('controllerWebMiddleware', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Tests\Fixtures\Controller@controllerWebMiddleware', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame(['web'], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertTrue($route->isWeb());
    }

    protected function routeClosureNullName(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(16, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('closureNullName', $route->getPath());

        $this->assertNull($route->getName());
        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Closure', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }

    protected function routeClosure(Route $route)
    {
        $this->assertIsInt($route->getPriority());
        $this->assertSame(17, $route->getPriority());

        $this->assertIsArray($route->getMethods());
        $this->assertSame(['GET', 'HEAD'], $route->getMethods());

        $this->assertNull($route->getDomain());

        $this->assertIsString($route->getPath());
        $this->assertSame('closure', $route->getPath());

        $this->assertIsString($route->getName());
        $this->assertSame('closure', $route->getName());

        $this->assertNull($route->getModule());

        $this->assertIsString($route->getAction());
        $this->assertSame('Closure', $route->getAction());

        $this->assertIsArray($route->getMiddlewares());
        $this->assertSame([], $route->getMiddlewares());

        $this->assertIsBool($route->getDeprecated());
        $this->assertFalse($route->getDeprecated());

        $this->assertNull($route->getSummary());
        $this->assertNull($route->getDescription());

        $this->assertIsArray($route->getExceptions()->toArray());
        $this->assertSame([], $route->getExceptions()->toArray());
        $this->assertTrue($route->getExceptions()->isEmpty());

        $this->assertNull($route->getResponse());

        $this->assertIsBool($route->isApi());
        $this->assertFalse($route->isApi());

        $this->assertIsBool($route->isWeb());
        $this->assertFalse($route->isWeb());
    }
}

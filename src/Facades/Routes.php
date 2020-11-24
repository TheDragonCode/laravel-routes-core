<?php

namespace Helldar\LaravelRoutesCore\Facades;

use Helldar\LaravelRoutesCore\Support\Routes as Support;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array get()
 * @method static Collection collection()
 * @method static Support setHideMethods(array $methods)
 * @method static Support setHideMatching(array $matching)
 * @method static Support setDomainForce(bool $force = false)
 * @method static Support setUrl(string $url)
 * @method static Support setNamespace(string $namespace = null)
 * @method static Support setApiMiddlewares(array $middlewares)
 * @method static Support setWebMiddlewares(array $middlewares)
 */
final class Routes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}

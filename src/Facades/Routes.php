<?php

namespace Helldar\LaravelRoutesCore\Facades;

use Helldar\LaravelRoutesCore\Support\Routes as Support;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array get()
 * @method static Collection collection()
 * @method static Support hideMethods(array $methods)
 * @method static Support hideMatching(array $matching)
 * @method static Support setHideMethods(array $methods)
 * @method static Support setHideMatching(array $matching)
 * @method static Support setDomainForce(bool $force = false)
 * @method static Support setUrl(string $url)
 * @method static Support setNamespace(string $namespace = null)
 */
final class Routes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}

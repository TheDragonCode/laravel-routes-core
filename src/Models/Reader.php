<?php

namespace Helldar\LaravelRoutesCore\Models;

use Helldar\LaravelRoutesCore\Traits\Makeable;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;
use Reflector;

class Reader
{
    use Makeable;

    protected $controller;

    protected $method;

    public function __construct(string $controller, string $method = null)
    {
        $this->controller = $controller;
        $this->method     = $method;
    }

    /**
     * @throws \ReflectionException
     *
     * @return \phpDocumentor\Reflection\DocBlock|null
     */
    public function forClass()
    {
        [$controller, $method] = $this->parse();

        return $this->get(
            $this->reflectionClass($controller)
        );
    }

    /**
     * @throws \ReflectionException
     *
     * @return \phpDocumentor\Reflection\DocBlock|null
     */
    public function forMethod()
    {
        [$controller, $method] = $this->parse();

        return $method
            ? $this->get(
                $this->reflectionMethod($this->reflectionClass($controller), $method)
            ) : null;
    }

    /**
     * @param  \Reflector|null  $reflection
     *
     * @return \phpDocumentor\Reflection\DocBlock|null
     */
    protected function get(Reflector $reflection = null): ?DocBlock
    {
        if ($reflection && $comment = $reflection->getDocComment()) {
            return DocBlockFactory::createInstance()->create($comment);
        }

        return null;
    }

    protected function parse(): array
    {
        if (is_null($this->method)) {
            return Str::contains($this->controller, '@')
                ? [Str::before($this->controller, '@'), Str::after($this->controller, '@')]
                : [$this->controller, null];
        }

        return [$this->controller, $this->method];
    }

    /**
     * Getting class reflection instance.
     *
     * @param  string  $class
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionClass
     */
    protected function reflectionClass(string $class)
    {
        return new ReflectionClass($class);
    }

    /**
     * Getting method reflection instance from reflection class.
     *
     * @param  \ReflectionClass  $class
     * @param  string  $method
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionMethod|null
     */
    protected function reflectionMethod(ReflectionClass $class, string $method)
    {
        return $class->hasMethod($method)
            ? $class->getMethod($method)
            : null;
    }
}

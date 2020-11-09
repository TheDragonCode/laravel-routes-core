<?php

namespace Helldar\LaravelRoutesCore\Support;

use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;

final class Annotation
{
    /**
     * @param  string  $controller
     * @param  string|null  $method
     *
     * @throws \ReflectionException
     *
     * @return string|null
     */
    public function summary(string $controller, string $method = null): ?string
    {
        if ($reader = $this->reader($controller, $method)) {
            return $reader->getSummary() ?: null;
        }

        return null;
    }

    /**
     * @param  string  $controller
     * @param  string|null  $method
     *
     * @throws \ReflectionException
     *
     * @return string|null
     */
    public function description(string $controller, string $method = null): ?string
    {
        if ($reader = $this->reader($controller, $method)) {
            return $reader->getDescription()->getBodyTemplate() ?: null;
        }

        return null;
    }

    /**
     * Determines if a class or method is deprecated.
     *
     * @param  string  $controller
     * @param  string|null  $method
     *
     * @throws \ReflectionException
     *
     * @return bool
     */
    public function isDeprecated(string $controller, string $method = null)
    {
        return is_null($method)
            ? $this->isDeprecatedClass($controller)
            : $this->isDeprecatedMethod($controller, $method);
    }

    /**
     * Determines if a method is deprecated.
     *
     * @param  string  $controller
     * @param  string  $method
     *
     * @throws \ReflectionException
     *
     * @return bool
     */
    public function isDeprecatedMethod(string $controller, string $method): bool
    {
        if ($reader = $this->reader($controller, $method)) {
            return $reader->hasTag('@deprecated');
        }

        return false;
    }

    /**
     * Determines if a class is deprecated.
     *
     * @param  string  $controller
     *
     * @throws \ReflectionException
     *
     * @return bool
     */
    public function isDeprecatedClass(string $controller)
    {
        if ($reader = $this->reader($controller)) {
            return $reader->hasTag('deprecated');
        }

        return false;
    }

    /**
     * Parsing a string into a class and method.
     *
     * @param  string  $action
     *
     * @return array
     */
    protected function parse(string $action)
    {
        return [
            Str::before($action, '@'),
            Str::after($action, '@'),
        ];
    }

    /**
     * @param  string  $controller
     * @param  string|null  $method
     *
     * @throws \ReflectionException
     *
     * @return \phpDocumentor\Reflection\DocBlock|null
     */
    protected function reader(string $controller, string $method = null): ?DocBlock
    {
        if (is_null($method)) {
            [$controller, $method] = $this->parse($controller);
        }

        $item = $this->reflection($controller, $method);

        if ($item && $comment = $item->getDocComment()) {
            return DocBlockFactory::createInstance()->create($comment);
        }

        return null;
    }

    /**
     * @param  string  $controller
     * @param  string|null  $method
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionClass|\ReflectionMethod
     */
    protected function reflection(string $controller, string $method = null)
    {
        $class = $this->reflectionClass($controller);

        return is_null($method) ? $class : $this->reflectionMethod($class, $method);
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

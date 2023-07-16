<?php

namespace DragonCode\LaravelRoutesCore\Models;

use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Str;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;
use ReflectionMethod;
use Reflector;

class Reader
{
    use Makeable;

    public function __construct(
        protected string $controller,
        protected ?string $method = null
    ) {}

    public function forClass(): ?DocBlock
    {
        [$controller, $method] = $this->parse();

        return $this->get(
            $this->reflectionClass($controller)
        );
    }

    public function forMethod(): ?DocBlock
    {
        [$controller, $method] = $this->parse();

        return $method
            ? $this->get(
                $this->reflectionMethod($this->reflectionClass($controller), $method)
            ) : null;
    }

    protected function get(?Reflector $reflection = null): ?DocBlock
    {
        if ($reflection && $comment = $reflection->getDocComment()) {
            return DocBlockFactory::createInstance()->create($comment);
        }

        return null;
    }

    protected function parse(): array
    {
        if (is_null($this->method)) {
            if (Str::contains($this->controller, '@')) {
                return [Str::before($this->controller, '@'), Str::after($this->controller, '@')];
            }

            return [$this->controller, null];
        }

        return [$this->controller, $this->method];
    }

    protected function reflectionClass(string $class): ReflectionClass
    {
        return new ReflectionClass($class);
    }

    protected function reflectionMethod(ReflectionClass $class, string $method): ?ReflectionMethod
    {
        return $class->hasMethod($method) ? $class->getMethod($method) : null;
    }
}

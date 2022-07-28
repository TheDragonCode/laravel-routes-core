<?php

namespace DragonCode\LaravelRoutesCore\Models;

use DragonCode\LaravelRoutesCore\Facades\Annotation;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Http\Builder;
use DragonCode\Support\Facades\Http\Url;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Collection;

class Route implements Arrayable
{
    /** @var \Illuminate\Routing\Route */
    protected IlluminateRoute $route;

    protected int $priority;

    protected array $hide_methods = [];

    protected bool $domain_force = false;

    protected ?string $url = null;

    protected ?string $namespace = null;

    protected array $api_middlewares = [];

    protected array $web_middlewares = [];

    public function __construct(IlluminateRoute $route, int $priority)
    {
        $this->route    = $route;
        $this->priority = ++$priority;
    }

    public function setHideMethods(array $hide_methods): static
    {
        $this->hide_methods = $hide_methods;

        return $this;
    }

    public function setDomainForce(bool $force): static
    {
        $this->domain_force = $force;

        return $this;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function setNamespace(?string $namespace): static
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function setApiMiddlewares(array $middlewares): static
    {
        $this->api_middlewares = $middlewares;

        return $this;
    }

    public function setWebMiddlewares(array $middlewares): static
    {
        $this->web_middlewares = $middlewares;

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getMethods(): array
    {
        $callback = static fn ($value) => Str::upper($value);

        return array_values(array_diff(
            Arr::map($this->route->methods(), $callback),
            Arr::map($this->hide_methods, $callback)
        ));
    }

    public function getDomain(): ?string
    {
        if ($domain = $this->route->domain()) {
            return $domain;
        }

        if ($this->domain_force && Url::is($this->url)) {
            return Builder::parse($this->url)->getDomain();
        }

        return null;
    }

    public function getPath(): string
    {
        return $this->route->uri();
    }

    public function getName(): ?string
    {
        return $this->route->getName();
    }

    public function getModule(): ?string
    {
        if ($this->namespace && Str::startsWith($this->getAction(), $this->namespace)) {
            $action = Str::after($this->getAction(), $this->namespace);
            $split  = Str::of($action)->ltrim('\\')->explode('\\')->toArray();

            return Arr::first($split);
        }

        return null;
    }

    public function getAction(): string
    {
        /** @var array|string $action */
        $action = $this->route->getActionName();

        return $action ? ltrim($action, '\\') : 'Closure';
    }

    public function getMiddlewares(): array
    {
        $middlewares = $this->route->middleware();
        $method      = 'controllerMiddleware';

        if (method_exists($this->route, $method) && is_callable([$this->route, $method])) {
            $middlewares = array_merge($middlewares, $this->route->{$method}());
        }

        return array_filter(array_values($middlewares), fn ($mw) => is_string($mw));
    }

    public function getSummary(): ?string
    {
        return Annotation::summary($this->getAction());
    }

    public function getDescription(): ?string
    {
        return Annotation::description($this->getAction());
    }

    public function getDeprecated(): bool
    {
        return Annotation::isDeprecated($this->getAction());
    }

    public function getExceptions(): Collection|array
    {
        return Annotation::exceptions($this->getAction());
    }

    public function getResponse()
    {
        return Annotation::response($this->getAction());
    }

    public function isApi(): bool
    {
        return $this->hasMiddleware($this->api_middlewares);
    }

    public function isWeb(): bool
    {
        return $this->hasMiddleware($this->web_middlewares);
    }

    public function toArray(): array
    {
        return [
            'priority'    => $this->getPriority(),
            'methods'     => $this->getMethods(),
            'domain'      => $this->getDomain(),
            'path'        => $this->getPath(),
            'name'        => $this->getName(),
            'module'      => $this->getModule(),
            'action'      => $this->getAction(),
            'middlewares' => $this->getMiddlewares(),
            'deprecated'  => $this->getDeprecated(),
            'summary'     => $this->getSummary(),
            'description' => $this->getDescription(),
            'exceptions'  => $this->getExceptions()->toArray(),
            'response'    => $this->getResponse(),
            'is_api'      => $this->isApi(),
            'is_web'      => $this->isWeb(),
        ];
    }

    protected function hasMiddleware(array $middlewares): bool
    {
        return !empty(array_intersect($middlewares, $this->getMiddlewares()));
    }
}

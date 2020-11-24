<?php

namespace Helldar\LaravelRoutesCore\Models;

use Helldar\LaravelRoutesCore\Facades\Annotation;
use Helldar\Support\Facades\Arr as ArrHelper;
use Helldar\Support\Facades\Http;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class Route implements Arrayable
{
    /** @var \Illuminate\Routing\Route */
    protected $route;

    protected $priority;

    protected $hide_methods = [];

    protected $domain_force = false;

    protected $url;

    protected $namespace;

    protected $api_middlewares = [];

    protected $web_middlewares = [];

    public function __construct(IlluminateRoute $route, int $priority)
    {
        $this->route    = $route;
        $this->priority = ++$priority;
    }

    public function setHideMethods(array $hide_methods)
    {
        $this->hide_methods = $hide_methods;

        return $this;
    }

    public function setDomainForce(bool $domain_force)
    {
        $this->domain_force = $domain_force;

        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function setApiMiddlewares(array $middlewares)
    {
        $this->api_middlewares = $middlewares;

        return $this;
    }

    public function setWebMiddlewares(array $middlewares)
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
        return array_values(array_diff(
            ArrHelper::map($this->route->methods(), 'mb_strtoupper'),
            ArrHelper::map($this->hide_methods, 'mb_strtoupper')
        ));
    }

    public function getDomain(): ?string
    {
        if ($domain = $this->route->domain()) {
            return $domain;
        }

        return $this->domain_force
            ? Http::domain($this->url)
            : null;
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
        $namespace = $this->namespace;

        if ($namespace && Str::startsWith($this->getAction(), $namespace)) {
            $action   = Str::after($this->getAction(), $namespace);
            $splitted = explode('\\', ltrim($action, '\\'));

            return Arr::first($splitted);
        }

        return null;
    }

    public function getAction(): string
    {
        return ltrim($this->route->getActionName(), '\\');
    }

    public function getMiddlewares(): array
    {
        $middlewares = $this->route->middleware();

        if (method_exists($this->route, 'controllerMiddleware') && is_callable([$this->route, 'controllerMiddleware'])) {
            $middlewares = array_merge($middlewares, $this->route->controllerMiddleware());
        }

        return array_values($middlewares);
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

    public function getExceptions(): Collection
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

    public function toArray()
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
        return ! empty(array_intersect($middlewares, $this->getMiddlewares()));
    }
}

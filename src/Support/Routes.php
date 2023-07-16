<?php

namespace DragonCode\LaravelRoutesCore\Support;

use DragonCode\Contracts\Routing\Core\Config;
use DragonCode\LaravelRoutesCore\Models\Route as RouteModel;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route as RouteFacade;

class Routes
{
    protected array $hide_methods = [];

    protected array $hide_matching = [];

    protected bool $domain_force = false;

    protected ?string $url = null;

    protected ?string $namespace = null;

    protected array $api_middlewares = [];

    protected array $web_middlewares = [];

    public function collection(): Collection
    {
        return $this->getRoutes()
            ->filter(fn (Route $route) => $this->allowUri($route->uri()) && $this->allowMethods($route->methods()))
            ->values()
            ->map(function (Route $route, int $index) {
                return (new RouteModel($route, $index))
                    ->setDomainForce($this->domain_force)
                    ->setHideMethods($this->hide_methods)
                    ->setUrl($this->url)
                    ->setNamespace($this->namespace)
                    ->setApiMiddlewares($this->api_middlewares)
                    ->setWebMiddlewares($this->web_middlewares);
            });
    }

    public function get(): array
    {
        return $this->collection()->toArray();
    }

    public function setFromConfig(Config $config): self
    {
        $this->setApiMiddlewares($config->getApiMiddleware());
        $this->setWebMiddlewares($config->getWebMiddleware());
        $this->setHideMethods($config->getHideMethods());
        $this->setHideMatching($config->getHideMatching());
        $this->setDomainForce($config->getDomainForce());
        $this->setUrl($config->getUrl());
        $this->setNamespace($config->getNamespace());

        return $this;
    }

    public function setHideMethods(?array $methods): self
    {
        $this->hide_methods = $methods;

        return $this;
    }

    public function setHideMatching(?array $matching): self
    {
        $this->hide_matching = $matching;

        return $this;
    }

    public function setDomainForce(?bool $force = false): self
    {
        $this->domain_force = $force;

        return $this;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setNamespace(?string $namespace = null): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function setApiMiddlewares(?array $middlewares): self
    {
        $this->api_middlewares = $middlewares;

        return $this;
    }

    public function setWebMiddlewares(?array $middlewares): self
    {
        $this->web_middlewares = $middlewares;

        return $this;
    }

    protected function getLaravelRoutes(): array|RouteCollectionInterface
    {
        return RouteFacade::getRoutes();
    }

    protected function getRoutes(): Collection
    {
        return collect($this->getLaravelRoutes());
    }

    protected function allowUri(string $uri): bool
    {
        foreach ($this->hide_matching as $regex) {
            if (preg_match($regex, ltrim($uri, '/'))) {
                return false;
            }
        }

        return true;
    }

    protected function allowMethods(array $methods): bool
    {
        return $this->hide_methods === ['*'] || count(array_diff($methods, $this->hide_methods)) > 0;
    }
}

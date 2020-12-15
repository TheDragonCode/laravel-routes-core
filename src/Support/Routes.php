<?php

namespace Helldar\LaravelRoutesCore\Support;

use Helldar\LaravelRoutesCore\Models\Route as RouteModel;
use Helldar\LaravelSupport\Facades\App as Application;
use Helldar\Support\Facades\Arr;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route as RouteFacade;

final class Routes
{
    protected $hide_methods = [];

    protected $hide_matching = [];

    protected $domain_force = false;

    protected $url = null;

    protected $namespace = null;

    protected $api_middlewares = [];

    protected $web_middlewares = [];

    public function collection(): Collection
    {
        return $this->getRoutes()
            ->filter(function (Route $route) {
                return $this->allowUri($route->uri()) && $this->allowMethods($route->methods());
            })
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

    public function setHideMethods(array $methods): self
    {
        $this->hide_methods = $methods;

        return $this;
    }

    public function setHideMatching(array $matching): self
    {
        $this->hide_matching = $matching;

        return $this;
    }

    public function setDomainForce(bool $force = false): self
    {
        $this->domain_force = $force;

        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setNamespace(string $namespace = null): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function setApiMiddlewares(array $middlewares): self
    {
        $this->api_middlewares = $middlewares;

        return $this;
    }

    public function setWebMiddlewares(array $middlewares): self
    {
        $this->web_middlewares = $middlewares;

        return $this;
    }

    /**
     * @return array|\Illuminate\Routing\RouteCollectionInterface
     */
    protected function getLaravelRoutes()
    {
        return RouteFacade::getRoutes();
    }

    protected function getLumenRoutes(): array
    {
        return array_map(static function (array $route) {
            $method = Arr::get($route, 'method');
            $uri    = Arr::get($route, 'uri');
            $action = Arr::get($route, 'action');

            return (new Route($method, $uri, $action))->uses($action);
        }, $this->getLaravelRoutes());
    }

    protected function getRoutes(): Collection
    {
        $routes = Application::isLumen()
            ? $this->getLumenRoutes()
            : $this->getLaravelRoutes();

        return collect($routes);
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

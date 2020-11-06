<?php

namespace Helldar\LaravelRoutesCore\Support;

use Helldar\LaravelRoutesCore\Models\Route as RouteModel;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route as RouteFacade;

final class Routes
{
    protected $hide_methods = [];

    protected $hide_matching = [];

    public function collection(): Collection
    {
        return $this->getRoutes()
            ->filter(function (Route $route) {
                return $this->allowUri($route->uri()) && $this->allowMethods($route->methods());
            })
            ->values()
            ->mapInto(RouteModel::class);
    }

    public function get(): array
    {
        return $this->collection()->toArray();
    }

    public function hideMethods(array $methods): self
    {
        $this->hide_methods = $methods;

        return $this;
    }

    public function hideMatching(array $matching): self
    {
        $this->hide_matching = $matching;

        return $this;
    }

    protected function getRoutes(): Collection
    {
        return collect(RouteFacade::getRoutes());
    }

    protected function allowUri(string $uri): bool
    {
        foreach ($this->hide_matching as $regex) {
            if (preg_match($regex, $uri)) {
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

<?php

namespace Tests\Fixtures;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
        $this->middleware('api')->only('controllerApiMiddleware');
        $this->middleware('web')->only('controllerWebMiddleware');
    }

    /**
     * Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse justo.
     */
    public function summary() {}

    /**
     * Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse justo.
     *
     * Lorem ipsum dolor sit amet, consectetur adipiscing elit.
     * Pellentesque lorem libero, ultricies ut nisl in, vestibulum egestas neque.
     * Nulla facilisi. Aenean vitae justo bibendum, scelerisque arcu cursus, scelerisque sapien.
     */
    public function description() {}

    /**
     * Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse justo.
     *
     * Lorem ipsum dolor sit amet, consectetur adipiscing elit.
     * Pellentesque lorem libero, ultricies ut nisl in, vestibulum egestas neque.
     * Nulla facilisi. Aenean vitae justo bibendum, scelerisque arcu cursus, scelerisque sapien.
     *
     * @deprecated
     */
    public function deprecated() {}

    public function without() {}

    /**
     * @deprecated
     */
    public function withoutDeprecated() {}

    public function routeApiMiddleware() {}

    public function controllerApiMiddleware() {}

    public function routeWebMiddleware() {}

    public function controllerWebMiddleware() {}

    public function incorrectDocBlock() {}
}

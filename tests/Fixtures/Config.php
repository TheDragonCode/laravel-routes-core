<?php

namespace Tests\Fixtures;

use DragonCode\Contracts\Routing\Core\Config as ConfigContract;

class Config implements ConfigContract
{
    public function getApiMiddleware(): array
    {
        return ['api', 'foo'];
    }

    public function getWebMiddleware(): array
    {
        return ['web', 'bar'];
    }

    public function getHideMethods(): array
    {
        return [];
    }

    public function getHideMatching(): array
    {
        return [];
    }

    public function getDomainForce(): bool
    {
        return true;
    }

    public function getUrl(): ?string
    {
        return null;
    }

    public function getNamespace(): ?string
    {
        return null;
    }
}

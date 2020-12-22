<?php

namespace Helldar\LaravelRoutesCore\Contracts;

interface Config
{
    public function getApiMiddleware(): array;

    public function getWebMiddleware(): array;

    public function getHideMethods(): array;

    public function getHideMatching(): array;

    public function getDomainForce(): bool;

    public function getUrl(): ?string;

    public function getNamespace(): ?string;
}

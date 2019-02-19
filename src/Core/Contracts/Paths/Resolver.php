<?php

namespace Statico\Core\Contracts\Paths;

interface Resolver
{
    public function resolve(string $name): ?string;

    public function index(): array;
}

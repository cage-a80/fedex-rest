<?php

namespace CageA80\FedEx;

use CageA80\FedEx\Services\Auth\AuthRequest;

abstract class AuthProviderAbstract implements \CageA80\FedEx\Contracts\AuthProvider
{
    protected array $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    abstract public function getToken(): string;

    abstract public function flush(): void;
}

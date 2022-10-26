<?php

namespace CageA80\FedEx\Contracts;

use CageA80\FedEx\Services\Auth\AuthResponse;

interface AuthProvider
{
    /**
     * Return auth token
     *
     * @return string
     */
    public function getToken(): string;

    /**
     * Clear cached token
     */
    public function flush(): void;
}

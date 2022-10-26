<?php

namespace CageA80\FedEx;

use CageA80\FedEx\Services\Auth\AuthRequest;

class AuthProvider extends AuthProviderAbstract
{
    protected ?string $token = null;

    protected ?int $expiresAt = null;

    public function getToken(): string
    {
        if ($this->token && (!$this->expiresAt || ($this->expiresAt && $this->expiresAt < time()))) {
            return $this->token;
        }

        $key = $this->config['key'];
        $secret = $this->config['secret'];

        $service = new AuthRequest($this->config);
        $response = $service->getToken($key, $secret);

        $this->token = $response->token();
        $this->expiresAt = $response->expiresIn() ? $response->expiresIn() + time() - 10 : null;

        return $this->token;
    }

    public function flush(): void
    {
        $this->token = null;
        $this->expiresAt = null;
    }
}

<?php

namespace CageA80\FedEx\Services\Auth;

class AuthResponse
{
    protected string $token = '';

    protected ?int $expiresIn;

    public function __construct(string $token, int $expiresIn = null)
    {
        $this->token = $token;
        $this->expiresIn = $expiresIn;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function expiresIn(): ?int
    {
        return $this->expiresIn;
    }
}

<?php

namespace CageA80\FedEx;

use CageA80\FedEx\Services\Auth\AuthRequest;
use Illuminate\Support\Facades\Cache;

class AuthCacheProvider extends AuthProviderAbstract
{
    const CACHE_KEY = 'fedex.token';

    public function getToken(): string
    {
        if ($token = Cache::get(self::CACHE_KEY)) {
            return $token;
        }

        $key = $this->config['key'];
        $secret = $this->config['secret'];

        $service = new AuthRequest($this->config);
        $response = $service->getToken($key, $secret);

        Cache::add('fedex.token', $response->token(), $response->expiresIn() - 10);

        return Cache::get('fedex.token');
    }

    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}

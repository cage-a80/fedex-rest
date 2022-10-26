<?php

namespace CageA80\FedEx\Services\Auth;

use CageA80\FedEx\RequestAbstract;
use CageA80\FedEx\Support\AuthGrantType;
use CageA80\FedEx\Support\Endpoint;

/**
 * Class Auth
 *
 * $config = [
 *  'environment' => EnvironmentType::SANDBOX | EnvironmentType::PRODUCTION,
 *  'provider' => 'curl',
 *  'authGrantType' => AuthGrantType::CLIENT | AuthGrantType::CSP,
 * ]
 *
 * @package FedEx
 */
class AuthRequest extends RequestAbstract
{
    public function getToken(string $apiKey, string $secretKey): AuthResponse
    {
        return $this->request(function () use ($apiKey, $secretKey) {
            $response = $this->getHttpProvider($this->config['providerConfig'] ?? [])
                ->post(
                    Endpoint::AUTH,
                    ['form_params' => [
                        'grant_type' => ($this->config['authGrantType'] ?? AuthGrantType::CLIENT),
                        'client_id' => $apiKey,
                        'client_secret' => $secretKey,
                    ]],
                    ['Accept' => 'application/json']
                );

            return new AuthResponse($response['access_token'], $response['expires_in']);
        });
    }
}

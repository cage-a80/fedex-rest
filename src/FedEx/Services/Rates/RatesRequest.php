<?php

namespace CageA80\FedEx\Services\Rates;

use CageA80\FedEx\RequestAbstract;
use CageA80\FedEx\Shipment;
use CageA80\FedEx\Support\Endpoint;

/**
 * Class Rates
 *
 * $config = [
 *  'environment' => EnvironmentType::SANDBOX | EnvironmentType::PRODUCTION,
 *  'provider' => 'guzzle',
 *  'accountNumber' => string,
 *  'token' => string,
 *  'carrierCodes' => array<CarrierCodeType>
 * ]
 *
 * @package FedEx
 */
class RatesRequest extends RequestAbstract
{
    public function getRates(Shipment $shipment): RatesResponse
    {
        $requestBody = $this->getRequestBody($shipment);

        return $this->request(function () use ($requestBody) {
            $request = $this->getHttpProvider();

            $response = $request->post(
                Endpoint::RATES,
                ['json' => $requestBody],
                [
                    'Authorization' => 'Bearer ' . $this->getApiToken(),
                    'X-locale' => 'en_US',
                    'Accept' => '*/*',
                ]
            );

            return new RatesResponse($response, $this->config);
        });
    }

    protected function getRequestBody(Shipment $shipment): array
    {
        $request = [
            'accountNumber' => ['value' => $this->config['accountNumber']],
            'requestedShipment' => $shipment->getData(),
            'carrierCodes' => $this->config['carrierCodes'] ?? []
        ];

        if (!!@$this->config['returnTransitTimes']) {
            $request['rateRequestControlParameters'] = [
                'returnTransitTimes' => $this->config['returnTransitTimes']
            ];
        }

        return $request;
    }
}

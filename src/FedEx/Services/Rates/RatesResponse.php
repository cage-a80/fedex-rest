<?php

namespace CageA80\FedEx\Services\Rates;

use Illuminate\Support\Arr;

class RatesResponse
{
    protected array $data = [];

    protected array $config = [];

    public function __construct(array $data, array $config = [])
    {
        $this->data = $data;
        $this->config = $config;
    }

    public function details(string $type = null): array
    {
        return array_map(
            function(array $service) use ($type) {
                $price = Arr::first($service['ratedShipmentDetails'], function(array $details) use ($type) {
                    return !$type || $details['rateType'] == $type;
                });

                return array_merge([
                    'serviceType' => $service['serviceType'],
                    'serviceName' => $service['serviceName'],
                    'shippingPrice' => $price['totalNetCharge'],
                    'rateType' => $type,
                    'raw' => $service
                ], isset($service['commit']) ? ['transitTime' => $service['commit']] : []);
            },
            Arr::get($this->data, 'output.rateReplyDetails', [])
        );
    }
}

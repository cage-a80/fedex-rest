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
        return array_values(array_filter(array_map(
            function (array $service) use ($type) {
                $price = Arr::first(
                    Arr::get($service, 'ratedShipmentDetails', []),
                    function (array $details) use ($type) {
                        return !$type || $details['rateType'] == $type;
                    }
                );

                return !empty($price)
                    ? array_merge([
                        'serviceType' => $service['serviceType'],
                        'serviceName' => $service['serviceName'],
                        'rateType' => $price['rateType'],
                        'charges' => [
                            'base' => $price['totalBaseCharge'],
                            'surcharge' => Arr::get($price, 'shipmentRateDetail.totalSurcharges'),
                            'discounts' => $price['totalDiscounts'],
                            'total' => $price['totalNetCharge'],
                            'currency' => $price['currency']
                        ],
                        'shipmentDetails' => $price,
                    ],
                        Arr::get($this->config, 'ratesRaw', false) ? ['raw' => $service] : [],
                        isset($service['commit']) ? ['transitTime' => $service['commit']] : []
                    )
                    : null;
            },
            Arr::get($this->data, 'output.rateReplyDetails', [])
        )));
    }
}

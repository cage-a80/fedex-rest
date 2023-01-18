<?php

namespace CageA80\FedEx;

use CageA80\FedEx\Exceptions\ValidationException;
use CageA80\FedEx\Services\Rates\RatesRequest;
use CageA80\FedEx\Services\Rates\RatesResponse;
use CageA80\FedEx\Support\DimensionUnit;
use CageA80\FedEx\Support\EdtRequestType;
use CageA80\FedEx\Support\PaymentMethod;
use CageA80\FedEx\Support\PickupType;
use CageA80\FedEx\Support\RateRequestType;
use CageA80\FedEx\Support\ShipmentPurpose;
use CageA80\FedEx\Support\WeightUnit;

/**
 * Class Shipment
 *
 * $config = [
 *  'preferredCurrency' => string,
 *  'rateRequestType' => array<RateRequestType>,
 *  'pickupType' => PickupType,
 *  'packagingType' => PackagingType,
 *  'edtRequestType' => EdtRequestType,
 * ]
 *
 * @package FedEx
 */
class Shipment
{
    protected array $config;
    protected array $data;

    public function __construct(array $config = [])
    {
        $this->config = $config;

        // provide default values
        $this->data = [
            'preferredCurrency' => $config['preferredCurrency'] ?? 'USD',
            'rateRequestType' => $config['rateRequestType'] ?? [RateRequestType::LIST],
            'pickupType' => $config['pickupType'] ?? PickupType::DROPOFF_AT_FEDEX_LOCATION,
            'edtRequestType' => $config['edtRequestType'] ?? EdtRequestType::NONE,
            'customsClearanceDetail' => [
                'commercialInvoice' => [
                    'shipmentPurpose' => ShipmentPurpose::COMMERCIAL,
                ],
                'dutiesPayment' => [
                    'paymentType' => $config['paymentType'] ?? PaymentMethod::SENDER
                ],
                'commodities' => [],
            ],
            'requestedPackageLineItems' => []
        ];

        if (!empty($config['packagingType'])) {
            $this->data['packagingType'] = $config['packagingType'];
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Specify sender address
     *
     * @param array $address
     * @return $this
     * @throws ValidationException
     */
    public function from(array $address): self
    {
        $address = array_merge(['residential' => false], $address);
        $this->validateAddress($address, 'shipper')
            ->data['shipper'] = ['address' => $address];

        return $this;
    }

    /**
     * Specify receiver address
     *
     * @param array $address
     * @return $this
     * @throws ValidationException
     */
    public function to(array $address): self
    {
        $address = array_merge(['residential' => false], $address);
        $this->validateAddress($address, 'recipient')
            ->data['recipient'] = ['address' => $address];
        return $this;
    }

    /**
     * Add a package to the shipment
     *
     * @param array $package
     * @return $this
     * @throws ValidationException
     */
    public function addPackage(array $package): self
    {
        if (isset($package['weight'])) {
            if (is_numeric($package['weight'])) {
                $package['weight'] = ['value' => $package['weight']];
            }

            if (is_array($package['weight']) && !isset($package['weight']['units'])) {
                $package['weight']['units'] = $this->config['weightUnits'] ?? WeightUnit::LB;
            }
        }

        $this->validatePackage($package)
            ->data['requestedPackageLineItems'][] = $package;

        return $this;
    }

    /**
     * Add a collection of packages to the shipment
     *
     * @param array $packages
     * @return $this
     * @throws ValidationException
     */
    public function addPackages(array $packages): self
    {
        foreach ($packages as $package) {
            $this->addPackage($package);
        }

        return $this;
    }

    /**
     * Add a commodity to the shipment
     *
     * @param array $commodity
     * @return $this
     * @throws ValidationException
     */
    public function addCommodity(array $commodity): self
    {
        $this->validateCommodity($commodity)
            ->data['customsClearanceDetail']['commodities'][] = $commodity;

        return $this;
    }

    /**
     * Add a collection of commodities to the shipment
     *
     * @param array $commodities
     * @return $this
     * @throws ValidationException
     */
    public function addCommodities(array $commodities): self
    {
        foreach ($commodities as $commodity) {
            $this->addCommodity($commodity);
        }

        return $this;
    }

    /**
     * Return shipment data body
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get shipping rates for the shipment
     *
     * @return RatesResponse
     */
    public function getRates(): RatesResponse
    {
        $ratesService = new RatesRequest($this->config);
        return $ratesService->getRates($this);
    }

    // region [VALIDATION]

    protected function validateAddress(array $address, string $type): self
    {
        if (empty($address['postalCode'])) {
            throw new ValidationException(ucfirst($type) . ' postal code is required');
        }

        if (empty($address['countryCode'])) {
            throw new ValidationException(ucfirst($type) . ' country code is required');
        }

        return $this;
    }

    protected function validatePackage(array $package): self
    {
        if (empty($package['weight']) || !is_array($package['weight'])) {
            throw new ValidationException('Package weight is required');
        }

        if (!in_array($package['weight']['units'], [WeightUnit::KG, WeightUnit::LB])) {
            throw new ValidationException('Invalid package weight units: ' . $package['weight']['units']);
        }

        if (!is_numeric(@$package['weight']['value']) || $package['weight']['value'] < 0) {
            throw new ValidationException('Invalid package weight: ' . $package['weight']['value']);
        }

        if (($this->config['maxPackageWeight'] ?? 0) && $package['weight']['value'] > $this->config['maxPackageWeight']) {
            throw new ValidationException('Package weight should be less or equal than ' . $this->config['maxPackageWeight']);
        }

        if (isset($package['dimensions'])) {
            if (empty($package['dimensions']['length'])) {
                throw new ValidationException('Package dimension length is required');
            }

            if (empty($package['dimensions']['width'])) {
                throw new ValidationException('Package dimension width is required');
            }

            if (empty($package['dimensions']['height'])) {
                throw new ValidationException('Package dimension height is required');
            }

            if (!in_array($package['dimensions']['units'], [DimensionUnit::CENTIMETERS, DimensionUnit::INCHES])) {
                throw new ValidationException('Invalid package dimension units: ' . $package['dimensions']['units']);
            }
        }

        return $this;
    }

    protected function validateCommodity(array $commodity): self
    {
        if (!count($commodity)) {
            throw new ValidationException('Commodity could not be empty');
        }

        if (isset($commodity['customsValue'])) {
            if (empty($commodity['customsValue']['amount'])) {
                throw new ValidationException('Commodity customsValue.amount is required');
            }

            if (empty($commodity['customsValue']['currency'])) {
                throw new ValidationException('Commodity customsValue.currency is required');
            }
        }

        return $this;
    }

    // endregion
}

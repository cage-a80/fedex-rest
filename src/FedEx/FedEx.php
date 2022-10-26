<?php

namespace CageA80\FedEx;

class FedEx
{
    protected array $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function shipment(): Shipment
    {
        return new Shipment($this->config);
    }
}

<?php

namespace CageA80\FedEx\Contracts;

interface HttpProvider
{
    public function post(string $url, array $data, array $headers = []): ?array;
}

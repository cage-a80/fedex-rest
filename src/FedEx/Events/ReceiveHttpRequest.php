<?php

namespace CageA80\FedEx\Events;

class ReceiveHttpRequest
{
    /**
     * Request endpoint URL
     *
     * @var string
     */
    public string $url;

    /**
     * Request payload
     *
     * @var array|null
     */
    public ?array $request;

    /**
     * Request headers
     *
     * @var array|null
     */
    public ?array $requestHeaders;

    /**
     * Response payload
     *
     * @var array|null
     */
    public ?array $response;

    public function __construct(string $url, ?array $request = null, ?array $requestHeaders = null, ?array $response = null)
    {
        $this->url = $url;
        $this->request = $request;
        $this->requestHeaders = $requestHeaders;
        $this->response = $response;
    }
}

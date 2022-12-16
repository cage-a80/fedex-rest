<?php

namespace CageA80\FedEx\Events;

class HttpClientError
{
    /**
     * Error message
     *
     * @var string
     */
    public string $message;

    /**
     * Error code
     *
     * @var int
     */
    public int $code;

    /**
     * Request endpoint URL
     *
     * @var string|null
     */
    public ?string $url;

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
     * Response data
     *
     * @var array|null
     */
    public ?array $response;

    public function __construct(string $message, int $code = 0, string $url = null, ?array $request = null, ?array $requestHeaders = null, ?array $response = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->url = $url;
        $this->request = $request;
        $this->requestHeaders = $requestHeaders;
        $this->response = $response;
    }
}

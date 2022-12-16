<?php

namespace CageA80\FedEx\Events;

class HttpServerError
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
    public ?array $data;

    /**
     * Request headers
     *
     * @var array|null
     */
    public ?array $headers;

    public function __construct(string $message, int $code = 0, string $url = null, ?array $data = null, ?array $headers = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->url = $url;
        $this->data = $data;
        $this->headers = $headers;
    }
}

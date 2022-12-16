<?php

namespace CageA80\FedEx\Events;

class SendingHttpRequest
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
    public ?array $data;

    /**
     * Request headers
     *
     * @var array|null
     */
    public ?array $headers;

    public function __construct(string $url, ?array $data = null, ?array $headers = null)
    {
        $this->url = $url;
        $this->data = $data;
        $this->headers = $headers;
    }
}

<?php

namespace CageA80\FedEx\Http;

use CageA80\FedEx\Contracts\HttpProvider;
use CageA80\FedEx\Exceptions\FedExException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\MessageInterface;

class GuzzleHttpProvider implements HttpProvider
{
    protected array $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function post(string $url, array $data = [], array $headers = []): ?array
    {
        try {
            // Prepare client
            $client = new Client($this->clientOptions());

            if (is_callable($this->config['onBeforeRequest'] ?? null)) {
                call_user_func($this->config['onBeforeRequest'], $url, $data, $headers);
            }

            // Prepare request parameters
            $options = array_merge_recursive(['headers' => $headers], count($data) ? $data : []);

            // Submit the POST request
            $response = $client->request('POST', $url, $options);

            // Parse to JSON if response content type is 'application/json'
            $result = $this->parseMessageBody($response);

            if (is_callable($this->config['onAfterRequest'] ?? null)) {
                call_user_func($this->config['onAfterRequest'], $url, $result, $response, $client);
            }

            return $result;
        } catch (ClientException $e) {
            $data = $this->parseMessageBody($e->getResponse());

            $error = ($data['errors'] ?? [])[0] ?? [];

            throw new FedExException($error['message'] ?? $e->getMessage(), $e->getCode(), ['response' => $data], $e);
        }
    }

    protected function clientOptions(): array
    {
        return array_merge(
            [RequestOptions::CONNECT_TIMEOUT => $this->config['timeout'] ?? 30],
            $this->config
        );
    }

    protected function parseMessageBody(MessageInterface $response)
    {
        $content = $response->getBody()->getContents();

        if (count($contentType = $response->getHeader('Content-Type'))) {
            $contentType = explode(';', $contentType[0])[0];

            if ($contentType === 'application/json') {
                return json_decode($content, JSON_OBJECT_AS_ARRAY);
            }
        }

        return $content;
    }
}

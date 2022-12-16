<?php

namespace CageA80\FedEx\Http;

use CageA80\FedEx\Contracts\HttpProvider;
use CageA80\FedEx\Exceptions\FedExException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
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
                call_user_func($this->config['onAfterRequest'], $url, $data, $headers, $result, $response, $client);
            }

            return $result;
        }
        catch (ClientException $e) {
            $responseData = $this->parseMessageBody($e->getResponse());

            $error = ($responseData['errors'] ?? [])[0] ?? [];

            if (is_callable($this->config['onClientError'] ?? null)) {
                call_user_func($this->config['onClientError'], $e->getMessage(), $e->getCode(), $url, $data, $headers, ['response' => $responseData]);
            }

            throw new FedExException($error['message'] ?? $e->getMessage(), $e->getCode(), [
                'request' => $data,
                'response' => $responseData
            ], $e);
        }
        catch (ServerException $e) {
            if (is_callable($this->config['onServerError'] ?? null)) {
                call_user_func($this->config['onServerError'], $e->getMessage(), $e->getCode(), $url, $data, $headers);
            }

            throw new FedExException($e->getMessage(), $e->getCode(), ['request' => $data], $e);
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

<?php

namespace CageA80\FedEx;

use CageA80\FedEx\Events\HttpClientError;
use CageA80\FedEx\Events\HttpServerError;
use CageA80\FedEx\Events\ReceiveHttpRequest;
use CageA80\FedEx\Events\SendingHttpRequest;
use CageA80\FedEx\Listeners\HttpClientErrorEventListener;
use CageA80\FedEx\Listeners\HttpServerErrorEventListener;
use CageA80\FedEx\Listeners\ReceiveHttpRequestEventListener;
use CageA80\FedEx\Listeners\SendingHttpRequestEventListener;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected array $listen = [
        SendingHttpRequest::class => [SendingHttpRequestEventListener::class],
        ReceiveHttpRequest::class => [ReceiveHttpRequestEventListener::class],
        HttpClientError::class => [HttpClientErrorEventListener::class],
        HttpServerError::class => [HttpServerErrorEventListener::class]
    ];

    /**
     * Register service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = $this->app['config']->get('fedex-rest');
        Arr::set($config, 'providerConfig.verify', Arr::get($config, 'verifySSL', true));

        $this->app->bind('fedex-rest', function () use ($config) {
            $config = $this->initEvents($config);

            return new FedEx($config);
        });

        $this->app->bind(
            'fedex-rest-logger',
            fn() => Log::channel(Arr::get($config, 'logChannel', $this->app['config']->get('logging.default')))
        );

        $this->registerListeners();
    }

    public function boot()
    {
        $configPath = __DIR__ . '/../../config/fedex-rest.php';
        $this->publishes([$configPath => $this->app->configPath('fedex-rest.php')], 'config');
    }

    protected function initEvents(array $config): array
    {
        $logInfo = Arr::get($config, 'log', false);

        $config['providerConfig'] = array_merge(Arr::get($config,'providerConfig'), [
            'onBeforeRequest' => $logInfo ?
                fn(string $url, array $data, array $headers) => Event::dispatch(new SendingHttpRequest(
                    $url,
                    count($data) ? $data : null,
                    count($headers) ? $headers : null
                )) : null,

            'onAfterRequest' => $logInfo ?
                fn(string $url, array $data, array $headers, ?array $response) => Event::dispatch(new ReceiveHttpRequest(
                    $url,
                    count($data) ? $data : null,
                    count($headers) ? $headers : null,
                    count($response) ? $response : null
                )) : null,

            'onClientError' =>
                fn(string $message, int $code, string $url, array $request, array $requestHeaders, array $response) => Event::dispatch(new HttpClientError(
                    $message, $code, $url, $request, $requestHeaders, $response
                )),

            'onServerError' =>
                fn(string $message, int $code, string $url, array $request, array $requestHeaders) => Event::dispatch(new HttpServerError(
                    $message, $code, $url, $request, $requestHeaders
                )),
        ]);

        return $config;
    }

    protected function registerListeners(): self
    {
        foreach ($this->listen as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                Event::listen($event, $listener);
            }
        }

        return $this;
    }
}

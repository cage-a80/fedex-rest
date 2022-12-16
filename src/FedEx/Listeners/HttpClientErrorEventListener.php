<?php

namespace CageA80\FedEx\Listeners;

use CageA80\FedEx\Events\HttpClientError;

/**
 * Class SendingHttpRequestEventListener
 *
 * @package CageA80\FedEx\Listeners
 */
class HttpClientErrorEventListener extends BaseEventListener
{
    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle(HttpClientError $event)
    {
        if ($logger = $this->getLogger()) {
            $logger->error('FedEx client error (' . $event->code . '): ' . $event->message);
            $logger->error(print_r([
                'url' => $event->url,
                'requestHeaders' => $event->requestHeaders,
                'request' => $event->request,
                'response' => $event->response
            ], true));
        }
    }
}

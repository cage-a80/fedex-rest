<?php

namespace CageA80\FedEx\Listeners;

use CageA80\FedEx\Events\HttpServerError;

/**
 * Class SendingHttpRequestEventListener
 *
 * @package CageA80\FedEx\Listeners
 */
class HttpServerErrorEventListener extends BaseEventListener
{
    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle(HttpServerError $event)
    {
        if ($logger = $this->getLogger()) {
            $logger->error('FedEx server error (' . $event->code . '): ' . $event->message);
            $logger->error(print_r([
                'url' => $event->url,
                'headers' => $event->headers,
                'payload' => $event->data,
            ], true));
        }
    }
}

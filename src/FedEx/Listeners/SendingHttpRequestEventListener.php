<?php

namespace CageA80\FedEx\Listeners;

use CageA80\FedEx\Events\SendingHttpRequest;

/**
 * Class SendingHttpRequestEventListener
 *
 * @package CageA80\FedEx\Listeners
 */
class SendingHttpRequestEventListener extends BaseEventListener
{
    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle(SendingHttpRequest $event)
    {
        if ($logger = $this->getLogger()) {
            $logger->info('FedEx request: ' . $event->url);
            $logger->info(print_r([
                'headers' => $event->headers,
                'payload' => $event->data,
            ], true));
        }
    }
}

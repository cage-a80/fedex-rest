<?php

namespace CageA80\FedEx\Listeners;

use CageA80\FedEx\Events\ReceiveHttpRequest;

/**
 * Class SendingHttpRequestEventListener
 *
 * @package CageA80\FedEx\Listeners
 */
class ReceiveHttpRequestEventListener extends BaseEventListener
{
    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle(ReceiveHttpRequest $event)
    {
        if ($logger = $this->getLogger()) {
            $logger->info('FedEx response: ' . $event->url);
            $logger->info(print_r([
                'response' => $event->response
            ], true));
        }
    }
}

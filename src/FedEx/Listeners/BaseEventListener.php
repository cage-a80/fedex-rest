<?php

namespace CageA80\FedEx\Listeners;

use Psr\Log\LoggerInterface;

/**
 * Class SendingHttpRequestEventListener
 *
 * @package CageA80\FedEx\Listeners
 */
abstract class BaseEventListener
{
    protected function getLogger(): ?LoggerInterface
    {
        return app()->make('fedex-rest-logger');
    }
}

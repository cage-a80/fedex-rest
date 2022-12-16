<?php

namespace CageA80\FedEx\Exceptions;

use Throwable;

class FedExException extends \Exception
{
    protected ?array $context = [];

    public function __construct($message = "", $code = 0, ?array $context = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->context = $context;
    }

    public function getContext(): ?array
    {
        return $this->context;
    }
}

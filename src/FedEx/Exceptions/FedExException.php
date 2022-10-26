<?php

namespace CageA80\FedEx\Exceptions;

use Throwable;

class FedExException extends \Exception
{
    protected array $data = [];

    public function __construct($message = "", $code = 0, array $data = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->data = $data;
    }
}

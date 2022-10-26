<?php

namespace CageA80\FedEx\Facades;

use Illuminate\Support\Facades\Facade;

class FedExFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fedex-rest';
    }
}

<?php

namespace CageA80\FedEx\Support;

/**
 * Class RateRequestType
 *
 * Indicate the type of rates to be returned
 *
 * @package FedEx\Support
 */
class RateRequestType
{
    /**
     * Returns FedEx published list rates in addition to account-specific rates (if applicable).
     */
    const LIST = 'LIST';

    /**
     * Returns rates in the preferred currency specified in the element preferredCurrency.
     */
    const INCENTIVE = 'INCENTIVE';

    /**
     * Returns account specific rates (Default).
     */
    const ACCOUNT = 'ACCOUNT';

    /**
     * This is one-time discount for incentivising the customer.
     */
    const PREFERRED = 'PREFERRED';
}

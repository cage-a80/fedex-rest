<?php

namespace CageA80\FedEx\Support;

/**
 * Class PickupType
 *
 * Indicate the pickup type method by which the shipment to be tendered to FedEx.
 *
 * @package FedEx\Support
 */
class PickupType
{
    /**
     * Indicates FedEx will be contacted to request a pickup.
     */
    const CONTACT_FEDEX_TO_SCHEDULE = 'CONTACT_FEDEX_TO_SCHEDULE';

    /**
     * Indicates Shipment will be dropped off at a FedEx Location.
     */
    const DROPOFF_AT_FEDEX_LOCATION = 'DROPOFF_AT_FEDEX_LOCATION';

    /**
     * Indicates Shipment will be picked up as part of a regular scheduled pickup.
     */
    const USE_SCHEDULED_PICKUP = 'USE_SCHEDULED_PICKUP';

    /**
     * Indicates the pickup will be scheduled by calling FedEx.
     */
    const ON_CALL = 'ON_CALL';

    /**
     * Indicates the pickup by FedEx Ground Package Returns Program.
     */
    const PACKAGE_RETURN_PROGRAM = 'PACKAGE_RETURN_PROGRAM';

    /**
     * Indicates the pickup at the regular pickup schedule.
     */
    const REGULAR_STOP = 'REGULAR_STOP';

    /**
     * Indicates the pickup specific to an Express tag or Ground call tag pickup request.
     */
    const TAG = 'TAG';
}

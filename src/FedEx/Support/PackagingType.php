<?php

namespace CageA80\FedEx\Support;

class PackagingType
{
    /**
     * Customer Packaging, FedEx Express® Services. Max Weight: 150 lbs/68 KG
     * Customer Packaging, FedEx Ground® Economy (Formerly known as FedEx SmartPost®) Services. Max weight: 70 lbs/32 KG
     */
    const YOUR_PACKAGING =          'YOUR_PACKAGING';

    /**
     * FedEx® Letters. Max Weight: 1 lbs/0.5 KG
     */
    const FEDEX_ENVELOPE =          'FEDEX_ENVELOPE';

    /**
     * FedEx® Box. Max Weight: 20 lbs/9 KG
     */
    const FEDEX_BOX =               'FEDEX_BOX';

    /**
     * FedEx® Small Box. Max Weight: 20 lbs/9 KG
     */
    const FEDEX_SMALL_BOX =         'FEDEX_SMALL_BOX';

    /**
     * FedEx® Medium Box. Max Weight: 20 lbs/9 KG
     */
    const FEDEX_MEDIUM_BOX =        'FEDEX_MEDIUM_BOX';

    /**
     * FedEx® Large Box. Max Weight: 20 lbs/9 KG
     */
    const FEDEX_LARGE_BOX =         'FEDEX_LARGE_BOX';

    /**
     * FedEx® Extra Large Box. Max Weight: 20 lbs/9 KG
     */
    const FEDEX_EXTRA_LARGE_BOX =   'FEDEX_EXTRA_LARGE_BOX';

    /**
     * FedEx® 10kg Box. Max Weight: 22 lbs/10 KG
     */
    const FEDEX_10KG_BOX =          'FEDEX_10KG_BOX';

    /**
     * FedEx® 25kg Box. Max Weight: 55 lbs/25 KG
     */
    const FEDEX_25KG_BOX =          'FEDEX_25KG_BOX';

    /**
     * FedEx® Pak. Max Weight: 20 lbs/9 KG
     */
    const FEDEX_PAK =               'FEDEX_PAK';

    /**
     * FedEx® Tube. Max Weight: 20 lbs/9 KG
     */
    const FEDEX_TUBE =              'FEDEX_TUBE';
}

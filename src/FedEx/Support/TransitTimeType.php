<?php

namespace CageA80\FedEx\Support;

class TransitTimeType
{
    const EIGHTEEN_DAYS = 'EIGHTEEN_DAYS';
    const EIGHT_DAYS = 'EIGHT_DAYS';
    const ELEVEN_DAYS = 'ELEVEN_DAYS';
    const FIFTEEN_DAYS = 'FIFTEEN_DAYS';
    const FIVE_DAYS = 'FIVE_DAYS';
    const FOURTEEN_DAYS = 'FOURTEEN_DAYS';
    const FOUR_DAYS = 'FOUR_DAYS';
    const NINETEEN_DAYS = 'NINETEEN_DAYS';
    const NINE_DAYS = 'NINE_DAYS';
    const ONE_DAY = 'ONE_DAY';
    const SEVENTEEN_DAYS = 'SEVENTEEN_DAYS';
    const SEVEN_DAYS = 'SEVEN_DAYS';
    const SIXTEEN_DAYS = 'SIXTEEN_DAYS';
    const SIX_DAYS = 'SIX_DAYS';
    const TEN_DAYS = 'TEN_DAYS';
    const THIRTEEN_DAYS = 'THIRTEEN_DAYS';
    const THREE_DAYS = 'THREE_DAYS';
    const TWELVE_DAYS = 'TWELVE_DAYS';
    const TWENTY_DAYS = 'TWENTY_DAYS';
    const TWO_DAYS = 'TWO_DAYS';
    const UNKNOWN = 'UNKNOWN';

    public static function toNumber($transitTimeType)
    {
        $list = [
            TransitTimeType::EIGHTEEN_DAYS => 18,
            TransitTimeType::EIGHT_DAYS => 8,
            TransitTimeType::ELEVEN_DAYS => 11,
            TransitTimeType::FIFTEEN_DAYS => 15,
            TransitTimeType::FIVE_DAYS => 5,
            TransitTimeType::FOURTEEN_DAYS => 14,
            TransitTimeType::FOUR_DAYS => 4,
            TransitTimeType::NINETEEN_DAYS => 19,
            TransitTimeType::NINE_DAYS => 9,
            TransitTimeType::ONE_DAY => 1,
            TransitTimeType::SEVENTEEN_DAYS => 17,
            TransitTimeType::SEVEN_DAYS => 7,
            TransitTimeType::SIXTEEN_DAYS => 16,
            TransitTimeType::SIX_DAYS => 6,
            TransitTimeType::TEN_DAYS => 10,
            TransitTimeType::THIRTEEN_DAYS => 13,
            TransitTimeType::THREE_DAYS => 3,
            TransitTimeType::TWELVE_DAYS => 12,
            TransitTimeType::TWENTY_DAYS => 20,
            TransitTimeType::TWO_DAYS => 2,
            TransitTimeType::UNKNOWN => null,
        ];

        return is_null($transitTimeType) ? null : ($list[$transitTimeType] ?? null);
    }
}

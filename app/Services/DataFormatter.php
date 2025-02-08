<?php

namespace App\Utils;

class DataFormatter
{
    /**
     * Remove all non-numeric characters from a string.
     */
    public function extractNumbers(string $input): string
    {
        return preg_replace("/[^0-9]/", "", $input);
    }

    /**
     * Format a phone number in the Brazilian format.
     */
    public function formatPhoneNumber(string $phone): string
    {
        $areaCode = substr($phone, 0, 2);
        $prefix = substr($phone, 2, 5);
        $suffix = substr($phone, 7);

        return "({$areaCode}) {$prefix}-{$suffix}";
    }
}

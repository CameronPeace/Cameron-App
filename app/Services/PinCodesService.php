<?php

namespace App\Services;

class PinCodesService
{
    /**
     * Generate a batch of pincodes.
     *
     * @param int $total
     * @param int $minLength
     * @param int $maxLength
     *
     * @return array<string> $batch
     */
    public function generatePinCodes(int $total = 20, int $minLength = 4, int $maxLength = 7)
    {
        $batch = [];

        // create an array of integers between the desired min and max.
        $numbers = range($minLength, $maxLength);
        $attempts = 0;

        while (count($batch) < $total) {

            // select an random index for our code length.
            $index = array_rand($numbers, 1);
            $pinCode = null;

            if ($attempts >= $total * 5) {
                break;
            }

            $pinCode = $this->generateSingleCode($numbers[$index]);

            if (!in_array($pinCode, $batch)) {
                $batch[] = $pinCode;
            }
            $attempts++;
        }

        return $batch;
    }

    /**
     * Generate a pin code at the desired length.
     *
     * @param int $codeLength The desired length of the code.
     *
     * @return string $pinCode
     */
    public function generateSingleCode(int $codeLength)
    {

        $code = [];

        // Create each int individually so we can have zeros.
        for ($k = 0; $k < $codeLength; $k++) {
            $code[] = rand(0, 9);
        }

        return implode('', $code);
    }
}

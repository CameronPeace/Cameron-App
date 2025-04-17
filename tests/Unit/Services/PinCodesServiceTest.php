<?php

namespace Tests\Unit\Services;

use App\Services\PinCodesService;
use PHPUnit\Framework\TestCase;

class PinCodesServiceTest extends TestCase
{

    /** The class instance we want to test */
    private $class;

    public function setUp(): void
    {
        $this->class = new PinCodesService();
    }

    /**
     * Test that the generateSingleCode function will return a code at our desired length.
     *
     * @return void
     */
    public function testGenerateSingleCodeLength()
    {
        $length = 12;
        $code = $this->class->generateSingleCode($length);
        $this->assertEquals(strlen($code), $length);

        $length = 35;
        $code = $this->class->generateSingleCode($length);
        $this->assertEquals(strlen($code), $length);
    }

    /**
     * Assert that when a total is provided our batch size matches that total.
     *
     * @return void
     */
    public function testGeneratePinCodesBatchSize()
    {
        $total = 35;
        $min = 4;
        $max = 8;

        $batch = $this->class->generatePinCodes($total, $min, $max);

        // assert after removing any dupes that the batch count matches the total. 
        $this->assertEquals(count(array_unique($batch)), $total);
    }

    /**
     * Assert that when a min is provided each pin is at least that size.
     *
     * @return void
     */
    public function testGeneratePinCodesHaveMinCharacters()
    {
        $total = 5;
        $min = 4;
        $max = 8;

        $batch = $this->class->generatePinCodes($total, $min, $max);

        foreach ($batch as $pinCode) {
            // iterate through each code and check its size is not less than we expected.
            $this->assertTrue(strlen($pinCode) >= $min);
        }
    }

    /**
     * Assert that when a max is provided each pin is at most that size.
     *
     * @return void
     */
    public function testGeneratePinCodesDoNotExceedMaxCharacters()
    {
        $total = 5;
        $min = 6;
        $max = 10;

        $batch = $this->class->generatePinCodes($total, $min, $max);

        foreach ($batch as $pinCode) {
            // iterate through each code and check its size is not more than we expected.
            $this->assertTrue(strlen($pinCode) <= $max);
        }
    }
}

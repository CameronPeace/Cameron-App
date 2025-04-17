<?php

namespace Tests\Unit\Services;

use App\Exceptions\ApiServiceException;
use App\Services\ApiService;
use PHPUnit\Framework\TestCase;

class ApiServiceTest extends TestCase
{

    /**
     * Test the getTopTheaters function returns expected data.
     *
     */
    public function testGetTopTheatersSuccess()
    {
        $limit = 5;
        $fromDate = '2024-01-01 00:00:00';
        $toDate = '2025-01-01 00:00:00';

        $return = [
            'theater_id' => 1,
            'theater_name' => 'test',
            'theater_city' => 'test',
            'theater_state' => 'test',
            'theater_street' => 'test',
            'theater_zip5' => 'test',
            'total_theater_sales' => 'test'
        ];

        $mock = $this->getMockBuilder('App\Services\Helpers\ApiRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->method('requestTopTheaters')->willReturn($return);

        $service = new ApiService($mock);

        $theaters = $service->getTopTheaters($fromDate, $toDate, $limit);

        $this->assertNotEmpty($theaters);
        $this->assertEqualsCanonicalizing($return, $theaters);
    }

     /**
     * Test the getTopTheaters function throws an exception when request fails.
     *
     */
    public function testGetTopTheatersThrowsError()
    {
        $limit = 5;
        $fromDate = '2024-01-01 00:00:00';
        $toDate = '2025-01-01 00:00:00';

        $return = [
            'status' => false,
            'message' => 'This test was destined to fail.'
        ];

        $mock = $this->getMockBuilder('App\Services\Helpers\ApiRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->method('requestTopTheaters')->willReturn($return);

        $this->expectException(ApiServiceException::class);
        $this->expectExceptionMessage($return['message']);
        
        $service = new ApiService($mock);

        $service->getTopTheaters($fromDate, $toDate, $limit);
    }
}

<?php

namespace Tests\Unit;

use App\Exceptions\YoutubeServiceException;
use App\Services\YoutubeService;
use PHPUnit\Framework\TestCase;

class YoutubeServiceTest extends TestCase
{

    public function testGetChannelId()
    {
        $handle = 'Bushy';
        $channelId = 'UCF5RrlbsxJjAVLWgOCoNHMg';

        $return = $this->buildChannelDataResponse($channelId);

        $mock = $this->getMockBuilder('App\Services\Helpers\YoutubeRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->method('requestChannelData')->willReturn($return);

        $service = new YoutubeService($mock);

        $returnedChannel = $service->getChannelId($handle);

        $this->assertEquals($returnedChannel, $channelId);
    }

    /**
     * Test data when querying channel data.
     *
     * @param string $channelId
     *
     * @return array
     */
    public function buildChannelDataResponse(string $channelId)
    {
        return array (
            'body' =>
            array (
              'kind' => 'youtube#channelListResponse',
              'etag' => 'pNKndOaJkmMQse7q6HJK0RTUe0g',
              'pageInfo' =>
              array (
                'totalResults' => 1,
                'resultsPerPage' => 5,
              ),
              'items' =>
              array (
                0 =>
                array (
                  'kind' => 'youtube#channel',
                  'etag' => 'nQuTpnrnquln43ouohjmhWHgmWY',
                  'id' => $channelId,
                ),
              ),
            ),
            'status' => 200,
        );
    }
}

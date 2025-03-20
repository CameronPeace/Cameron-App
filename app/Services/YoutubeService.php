<?php

namespace App\Services;

use App\Exceptions\YoutubeServiceException;
use App\Models\Repositories\ContentFeedRepository;
use App\Services\Helpers\PubSubHubRequest;
use App\Services\Helpers\YoutubeRequest;

class YoutubeService
{

    /**
     * The youtube request instance utilitzed to make requests to Youtube's Api.
     *
     * @var YoutubeRequest
     */
    private $youtubeRequest;

    public function __construct(YouTubeRequest $youtubeRequest = null)
    {
        $this->setYoutubeRequest($youtubeRequest ?? new YouTubeRequest());
    }

    public function getYoutuberContent(string $handle, string $pageToken = null, int $maxResults = 5)
    {

        $channelId = $this->getChannelId($handle);

        $params = [
            'part' => 'snippet',
            'maxResults' => $maxResults,
            'channelId' => $channelId, //Bushy's channel ID UCF5RrlbsxJjAVLWgOCoNHMg
            'order' => 'date'
        ];

        if (!empty($pageToken)) {
            $params['pageToken'] = $pageToken;
        }

        try {
            return $this->youtubeRequest->requestContent($params);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    /**
     * Pull youtube channel data by the channel handle.
     * Right now this is only pulling the ID but we can expand this function to get more channel data as we need it.
     * @param string $handle
     *
     * @return void
     */
    public function getChannelDataByHandle(string $handle = 'Bushy')
    {
        $params = [
            'part' => 'id',
            'forHandle' => $handle,
        ];

        try {
            $content = $this->youtubeRequest->requestChannelData($params);

            if (empty($content['body']['items'])) {
                throw new YoutubeServiceException('Could not find channel data.');
            }

            return $content['body']['items'][0];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    /**
     * Return a youtubers channel ID. We will edit this function to query the database once we figure out how we want to save our data.
     */
    public function getChannelId(string $handle = 'Bushy')
    {
        try {
            $channelData = $this->getChannelDataByHandle($handle);


            return $channelData['id'];
            // TODO lets see what this returns when the data isn't found.

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
    /**
     * Set our youtube request instance.
     *
     * @param YoutubeRequest $youtubeRequest
     *
     * @return void
     */
    public function setYoutubeRequest(YoutubeRequest $youtubeRequest)
    {
        $this->youtubeRequest = $youtubeRequest;
    }

    /**
     * Get our youtube request instance.
     *
     * @return YoutubeRequest.
     */
    public function getYoutubeRequest()
    {
        return $this->youtubeRequest;
    }

    /**
     * Subscribe to a youtubers uploads.
     *
     * @param string $channelId
     *
     * @return void
     */
    public function subscribeToChannelWebhooks($channelId)
    {
        $request = new PubSubHubRequest();

        $response = $request->subscribeToChannelWebhooks($channelId);

        \Log::info($response);
    }

    /**
     * Add a set amount of a creators videos to our feed in order of recency.
     *
     * @param string $handle
     * @param int $total
     *
     * @return array $saved
     */
    public function ingestYoutubeContent(string $handle, int $total = 30)
    {
        $saved = [];
        $pageToken = '';
        while ($total > 0) {

            $youtuberContent = $this->getYoutuberContent($handle, $pageToken);

            if (empty($youtuberContent['body']['items'])) {
                return $saved;
            }

            $videoItems = $youtuberContent['body']['items'];
            $pageToken = $youtuberContent['body']['nextPageToken'] ?? '';
            $feedRepository = new ContentFeedRepository();

            foreach ($videoItems as $data) {

                $videoId = $data['id']['videoId'];
                $channelId = $data['snippet']['channelId'];
                $publishedAt = $data['snippet']['publishedAt'];
                $videoTitle = $data['snippet']['title'];

                $insert = $feedRepository->addOnlyNewContent($channelId, 'youtube', $videoId, $videoTitle, $publishedAt);

                $saved[$videoId] = $insert;
                $total--;
            }
        }

        return $saved;
    }
}

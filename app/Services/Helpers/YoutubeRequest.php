<?php

namespace App\Services\Helpers;

class YoutubeRequest extends Request
{

    const YOUTUBE_API_URL = "https://www.googleapis.com/youtube/v3";

    /** The Youtube API key */
    private $key;

    public function __construct()
    {
        parent::__construct();
        $this->key = config('app.youtube_api_key');
    }

    /**
     * Get the url to make requests to Youtube's data API,
     *
     * @param string $path
     *
     * @return void
     */
    public function getRequestUrl($path)
    {
        return self::YOUTUBE_API_URL . "/" . $path;
    }

    /**
     * Request youtuber content.
     *
     * @param array $params
     *
     * @return array 
     */
    public function requestContent(array $params)
    {
        $params['key'] = $this->key;
        return $this->call('GET', "search", $params);
    }

    /**
     * Request channel data.
     *
     * @param array $params
     *
     * @return array $channelContent
     */
    public function requestChannelData(array $params)
    {
        $params['key'] = $this->key;
        return $this->call('GET', "channels", $params);
    }
}

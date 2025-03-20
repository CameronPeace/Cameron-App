<?php

namespace App\Services\Helpers;

class PubSubHubRequest extends Request
{

    const HUB_URL = "http://pubsubhubbub.appspot.com";

    public function __construct()
    {
        parent::__construct();
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
        return self::HUB_URL . "/" . $path;
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
        return $this->call('GET', "search", $params);
    }

    public function subscribeToChannelWebhooks(string $channelId)
    {
        $topicUrl = 'https://www.youtube.com/xml/feeds/videos.xml?channel_id={CHANNEL_ID}';

        // $callbackUrl = 'https://' . $_SERVER['SERVER_NAME'] . 'youtubersubscriber.php';
        $callbackUrl = 'https://d5jq9gt4al.execute-api.us-east-2.amazonaws.com/social/callback/youtube';
        $data = array(
            'hub.mode' => 'subscribe',
            'hub.callback' => $callbackUrl,
            'hub.lease_seconds' => 60 * 60 * 24 * 365,
            'hub.verify' => 'async',
            'hub.topic' => str_replace(['{CHANNEL_ID}'], array($channelId), $topicUrl)
        );

        return $this->call('POST', 'subscribe', $data, true);
    }
}

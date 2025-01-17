<?php

namespace App\Models\Repositories;

use App\Models\ContentFeed;

class ContentFeedRepository
{
    protected $table;

    public function __construct()
    {
        $this->table = new ContentFeed;
    }

    
    /**
     * Save new content.
     *
     * @param string $channelId
     * @param int|string $type
     * @param string $contentId
     * @param string $contentTitle
     * @param string publishedDate
     *
     * @return boolean
     */
    public function saveContent(string $channelId, int|string $type, string $contentId, string $contentTitle = null, string $publishedDate = null)
    {
        return $this->table->insert(
            [
                'channel_id' => $channelId,
                'type' => is_int($type) ? $type : $this->table->getType($type),
                'content_id' => $contentId,
                'created_at' => now()->toDateTimeString(),
                'title' => $contentTitle,
                'published_at' => !empty($publishedDate) ? date('Y-m-d H:i:s', strtotime($publishedDate)) : null
            ]
        );
    }

    /**
     * Add new content videos to the feed.
     *
     * @param string $channelId The channel ID.
     * @param string $type The channel type.
     * @param string $contentId The content ID.
     *
     * @return boolean
     */
    public function addOnlyNewContent(string $channelId, string $type, string $contentId, string $contentTitle = null, string $publishedDate = null)
    {

        $existing = $this->table->select('id')
            ->where('type', $this->table->getType($type))
            ->where('content_id', $contentId)
            ->where('channel_id', $channelId)
            ->get();

        if (!$existing->isEmpty()) {
            return null;
        }

        return $this->saveContent($channelId, $type, $contentId, $contentTitle, $publishedDate);
    }
}

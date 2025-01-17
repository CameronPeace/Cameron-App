<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentFeed extends Model
{
    protected $table = 'content_feed';

    const CONTENT_TYPES = [
        'youtube' => 1,
        'instagram' => 2
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'channel_id',
        'type',
        'video_id',
        'title',
        'published_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'published_at' => 'datetime'
    ];

    /**
     * Return the type column int translation.
     *
     * @param string $type
     *
     * @return int
     */
    public function getType(string $type)
    {
        return self::CONTENT_TYPES[strtolower(trim($type))] ?? 0;
    }
}

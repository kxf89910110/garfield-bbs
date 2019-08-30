<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        // XSS filtering
        $topic->body = clean($topic->body, 'user_topic_body');

        // Generate topic excerpts
        $topic->excerpt = make_excerpt($topic->body);

        // If the slug field hasn't content, use the translator to translate the title
        if ( ! $topic->slug) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}

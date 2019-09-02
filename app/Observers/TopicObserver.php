<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;

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
    }

    public function saved(Topic $topic)
    {
        // If the slug field hasn't content, use the translator to translate the title
        if ( ! $topic->slug) {

            // Push task to queue
            dispatch(new TranslateSlug($topic));
        }
    }

    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}

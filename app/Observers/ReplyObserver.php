<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
<<<<<<< HEAD
    {
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }

    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
=======
    {
        // $reply->topic->reply_count = $reply->topic->replies->count();
        // $reply->topic->save();
        $topic = $reply->topic;
        $reply->topic->increment('reply_count', 1);

         // Notify the topic author of new comments
        // $reply->topic->user->notify(new TopicReplied($reply));
        $topic->user->topicNotify(new TopicReplied($reply));
    }

    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
>>>>>>> L03_5.8
    }
}

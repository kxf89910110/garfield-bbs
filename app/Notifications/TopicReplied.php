<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Reply;

class TopicReplied extends Notification
{
    use Queueable;

    public $reply;

<<<<<<< HEAD
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        // Inject the reply  entity for easy use in the toDatabase method
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //Channel to turn on notifications
=======
    public function __construct(Reply $reply)
    {
        // Inject the reply entity for easy use in the toDatabase method
        $this->reply = $reply;
    }

    public function via($notifiable)
    {
        // Channel to turn on notifications
>>>>>>> L03_5.8
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $topic = $this->reply->topic;
<<<<<<< HEAD
        $link = $topic->link(['#reply' . $this->reply->id]);
=======
        $link =  $topic->link(['#reply' . $this->reply->id]);
>>>>>>> L03_5.8

        // Data stored in the database
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'user_id' => $this->reply->user->id,
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'topic_link' => $link,
            'topic_id' => $topic->id,
            'topic_title' => $topic->title,
        ];
    }
}

<?php

namespace App\Listeners;

use JPush\Client;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\DatabaseNotification;

class PushNotification implements ShouldQueue
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function handle(DatabaseNotification $notification)
    {
        // Local environment does not push by default
        if (app()->environment('local')) {
            return;
        }

        $user = $notification->notifiable;

        // No push without registration_id
        if (!$user->registration_id) {
            return;
        }

        // Forward news
        $this->client->push()
            ->setPlatform('all')
            ->addRegistrationId($user->registration_id)
            ->setNotificationAlert(strip_tags($notification->data['reply_content']))
            ->send();

    }
}

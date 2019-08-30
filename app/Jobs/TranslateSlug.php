<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Topic $topic)
    {
        // The Eloquent model is received in the queue task builder and will only serialize the model ID
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Request Baidu API interface for translation
        $slug = app(SlugTranslateHandler::class)->translate($this->topic->title);

        // In order to avoid the model monitor infinite loop call, we use the DB class to directly operate on the database.
        \DB::table('topics')->where('id', $this->topic->id)->update(['slug' => $slug]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        // An array of all user IDs, such as: [1,2,3,4]
        $user_ids = User::all()->pluck('id')->toArray();

        //  An array of all topic IDs, such as: [1,2,3,4]
        $topic_ids = Topic::all()->pluck('id')->toArray();

        // Get a Faker instance
        $faker = app(Faker\Generator::class);

        $replys = factory(Reply::class)
                        ->times(1000)
                        ->make()
                        ->each(function ($reply, $index)
                            use ($user_ids, $topic_ids, $faker)
        {
            // Randomly take one from the user ID array and assign it.
            $reply->user_id = $faker->randomElement($user_ids);

            // Topic ID, ibid.
            $reply->topic_id = $faker->randomElement($topic_ids);
        });

        // Convert the data collection to an array and insert it into the database.
        Reply::insert($replys->toArray());
    }

}


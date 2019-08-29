<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        // An array of all user IDs, such as: [1,2,3,4]
        $user_ids = User::all()->pluck('id')->toArray();

        //  An array of all classification IDs, such as: [1,2,3,4]
        $category_ids = Category::all()->pluck('id')->toArray();

        // Get a Faker instance
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)
                        ->times(50)
                        ->make()
                        ->each(function ($topic, $index)
                            use ($user_ids, $category_ids, $faker)
        {
            // Randomly take one from the user ID array and assign it.
            $topic->user_id = $faker->randomElement($user_ids);

            // Topic classification, ibid.
            $topic->category_id = $faker->randomElement($category_ids);
        });

        // Convert the data collection to an array and insert it into the database.
        Topic::insert($topics->toArray());
    }
}


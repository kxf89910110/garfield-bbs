<?php

    namespace App\Models\Traits;

    use App\Models\Topic;
    use App\Models\Reply;
    use Carbon\Carbon;
    use Cache;
    use DB;
    use Arr;

    trait ActiveUserHelper
    {
        // Used to store temporary user data
        protected $users = [];

        // Configuration information
        protected $topic_weight = 4;
        protected $reply_weight = 1;
        protected $pass_days = 7;
        protected $user_number = 6;

        // Cache related configuration
        protected $cache_key = 'larabbs_active_users';
        protected $cache_expire_in_seconds = 65 * 60;

        public function getActiveUsers()
        {
            // Try to retrieve the data corresponding to cache_key from the cache.If it can be obtained, it will return the data directly.
            // Otherwise, run the code in the anonymous function to retrieve the active user data, and return it while doing the cache.
            return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function(){
                return $this->calculateActiveUsers();
            });
        }

        public function calculateAndCacheActiveUsers()
        {
            // Get active user list
            $active_users = $this->calculateActiveUsers();
            // and cached
            $this->cacheActiveUsers($active_users);
        }

        private function calculateActiveUsers()
        {
            $this->calculateTopicScore();
            $this->calculateReplyScore();

            // Array sorted by score
            $users = Arr::sort($this->users, function ($user) {
                return $user['score'];
            });

            // What we need is reverse order, the high score is before, the second parameter is to keep the KEY of the array unchanged.
            $users = array_reverse($users, true);

            // Only get the quantity we want
            $users = array_slice($users, 0, $this->user_number, true);

            // Create a new empty collection
            $active_users = collect();

            foreach ($users as $user_id => $user) {
                // Looking for users can be found
                $user = $this->find($user_id);

                // If there is this user in the database
                if ($user) {

                    // Put this user entity at the end of the collection
                    $active_users->push($user);
                }
            }

            // Return data
            return $active_users;
        }

        private function calculateTopicScore()
        {
            // From the topic data table, take out the limited time range ($pass_days), and users who have published topics
            // And at the same time take out the number of topics posted by the user during this period of time.
            $topic_users = Topic::query()->select(DB::raw('user_id, count(*) as topic_count'))
                                        ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                        ->groupBy('user_id')
                                        ->get();
            // Calculate the score based on the number of topics
            foreach ($topic_users as $value) {
                $this->users[$value->user_id]['score'] = $value->topic_count * $this->topic_weight;
            }
        }

        private function calculateReplyScore()
        {
            // Retrieved from the response data table for a limited time range ($pass_days)
            // And at the same time take out the number of users who posted the reply during this period of time.
            $reply_users = Reply::query()->select(DB::raw('user_id, count(*) as reply_count'))
                                        ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                        ->groupBy('user_id')
                                        ->get();
            // Calculate the score based on the number of responses
            foreach ($reply_users as $value) {
                $reply_score = $value->reply_count * $this->reply_weight;
                if (isset($this->users[$value->user_id])) {
                    $this->users[$value->user_id]['score'] += $reply_score;
                } else {
                    $this->users[$value->user_id]['score'] = $reply_score;
                }
            }
        }

        private function cacheActiveUsers($active_users)
        {
            // Put data in the cache
            Cache::put($this->cache_key, $active_users, $this->cache_expire_in_seconds);
        }
    }

<?php

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{
    // Cache related
    protected $hash_prefix = 'garfield-bbs_last_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {
        // Get today's Redis hash table name, such as: larabbs_last_actived_at_2017-10-21
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // Field name, such as: user_1
        $field = $this->getHashField();

        // Current time, such as:2017-10-21 08:35:15
        $now = Carbon::now()->toDateTimeString();

        // Data is written to Redis and the field already exists will be updated
        Redis::hSet($hash, $field, $now);
    }

    public function syncUserActivedAt()
    {
        // Get yesterday's hash table name, such as:larabbs_last_actived_at_2017-10-21
        $hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());

        // Get all the data in the hash table from Redis
        $dates = Redis::hGetAll($hash);

        // Traverse and synchronize to the database
        foreach ($dates as $user_id => $actived_at) {
            // Will convert 'user_1' to 1
            $user_id = str_replace($this->field_prefix, '', $user_id);

            // Update to the database only when the user exists
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        // Database-centric storage, both synchronized and deleted
        Redis::del($hash);
    }

    public function getLastActivedAtAttribute($value)
    {
        // Get the hash table name corresponding to today
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // Field name, such as: user_1
        $field = $this->getHashField();

        // The ternary operator, the data of Redis is preferred, otherwise it is used in the database.
        $datetime = Redis::hGet($hash, $field) ? : $value;

        // Carbon entity corresponding to the return time if it exists
        if ($datetime) {
            return new Carbon($datetime);
        } else {
            // Otherwise use user registration time
            return $this->created_at;
        }
    }

    public function getHashFromDateString($date)
    {
        // The name of the Redis hash table, such as: larabbs_last_actived_at_2017-10-21
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        // Field name, such as: user_1
        return $this->field_prefix . $this->id;
    }
}

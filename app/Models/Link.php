<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Link extends Model
{
    protected $fillable = ['title', 'link'];

<<<<<<< HEAD
    public $cache_key = 'garfield-bbs_links';
=======
    public $cache_key = 'larabbs_links';
>>>>>>> L03_5.8
    protected $cache_expire_in_seconds = 1440 * 60;

    public function getAllCached()
    {
        // Try to retrieve the data corresponding to cache_key from the cache.If it can be obtained, it will return the data directly.
        // Otherwise, run the code in the anonymous function to retrieve all the data in the links table, and return the cache at the same time.
        return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function(){
            return $this->all();
        });
    }
}

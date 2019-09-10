<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    // Clear the cache corresponding to cache_key when saving
    public function saved(Link $link)
    {
        cache::forget($link->cache_key);
    }
}

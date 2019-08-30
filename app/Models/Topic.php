<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query, $order)
    {
        // Different sorts, using different data read logic
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }
        // Preload prevents N+1 issues
        return $query->with('user', 'category');
    }

    public function scopeRecentReplied($query)
    {
        // When the topic has a new reply, we will write logic to update the reply_count attribute of the topic model
        // The framework automatically triggers the update of the data model updated_at timestamp
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // Sort by creation time
        return $query->orderBy('created_at', 'desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}

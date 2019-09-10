<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;
use App\Models\User;
use App\Models\Link;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Topic $topic, User $user, Link $link)
    {
        // Read the topic associated with the category ID and page through every 20
        $topics = $topic->withOrder($request->order)
                        ->where('category_id', $category->id)
                        ->paginate(20);
        // Active user list
        $active_users = $user->getActiveUsers();
        // Resource link
        $links = $link->getAllCached();
        // Pass the variable topic and classify into the template
        return view('topics.index', compact('topics', 'category', 'active_users', 'links'));
    }
}

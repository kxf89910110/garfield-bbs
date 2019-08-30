<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
        // Read the topic associated with the category ID and page through every 20
        $topics = Topic::where('category_id', $category->id)->paginate(20);
        // Pass the variable topic and classify into the template
        return view('topics.index', compact('topics', 'category'));
    }
}

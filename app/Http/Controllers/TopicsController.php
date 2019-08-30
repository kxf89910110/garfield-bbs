<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Auth;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
		$topics = Topic::withOrder($request->order)->paginate(30);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
		$topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

		return redirect()->route('topics.show', $topic->id)->with('success', 'Post created successfully!');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('success', 'Update completed');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // Initialize the returned data, the default is failed
        $data = [
            'success' => false,
            'msg' => 'Upload failed',
            'file_path' => ''
        ];
        // Determine if there is an upload file and assign it to $file
        if ($file = $request->upload_file) {
            // Save image to local
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // If the picture is saved successfully
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = "Upload success";
                $data['success'] = true;
            }
        }
        return $data;
    }
}

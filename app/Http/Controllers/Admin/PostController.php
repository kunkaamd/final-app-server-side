<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Post;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Series;
use App\User;


class PostController extends Controller {

	/**
	 * Display a listing of post
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $post = Post::with("series")->with("user")->get();

		return view('admin.post.index', compact('post'));
	}

	/**
	 * Show the form for creating a new post
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $series = Series::pluck("name", "id")->prepend('Please select', 0);
$user = User::pluck("email", "id")->prepend('Please select', 0);

	    
        $published = Post::$published;

	    return view('admin.post.create', compact("series", "user", "published"));
	}

	/**
	 * Store a newly created post in storage.
	 *
     * @param CreatePostRequest|Request $request
	 */
	public function store(CreatePostRequest $request)
	{
	    $request = $this->saveFiles($request);
		Post::create($request->all());

		return redirect()->route(config('quickadmin.route').'.post.index');
	}

	/**
	 * Show the form for editing the specified post.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$post = Post::find($id);
	    $series = Series::pluck("name", "id")->prepend('Please select', 0);
$user = User::pluck("email", "id")->prepend('Please select', 0);

	    
        $published = Post::$published;

		return view('admin.post.edit', compact('post', "series", "user", "published"));
	}

	/**
	 * Update the specified post in storage.
     * @param UpdatePostRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdatePostRequest $request)
	{
		$post = Post::findOrFail($id);

        $request = $this->saveFiles($request);

		$post->update($request->all());

		return redirect()->route(config('quickadmin.route').'.post.index');
	}

	/**
	 * Remove the specified post from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Post::destroy($id);

		return redirect()->route(config('quickadmin.route').'.post.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Post::destroy($toDelete);
        } else {
            Post::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.post.index');
    }

}

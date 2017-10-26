<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Comment;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Request;

use App\User;
use App\Post;


class CommentController extends Controller {

	/**
	 * Display a listing of comment
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $comment = Comment::with("user")->with("post")->get();

		return view('admin.comment.index', compact('comment'));
	}

	/**
	 * Show the form for creating a new comment
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::pluck("email", "id")->prepend('Please select', 0);
$post = Post::pluck("title", "id")->prepend('Please select', 0);

	    
	    return view('admin.comment.create', compact("user", "post"));
	}

	/**
	 * Store a newly created comment in storage.
	 *
     * @param CreateCommentRequest|Request $request
	 */
	public function store(CreateCommentRequest $request)
	{
	    
		Comment::create($request->all());

		return redirect()->route(config('quickadmin.route').'.comment.index');
	}

	/**
	 * Show the form for editing the specified comment.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$comment = Comment::find($id);
	    $user = User::pluck("email", "id")->prepend('Please select', 0);
$post = Post::pluck("title", "id")->prepend('Please select', 0);

	    
		return view('admin.comment.edit', compact('comment', "user", "post"));
	}

	/**
	 * Update the specified comment in storage.
     * @param UpdateCommentRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateCommentRequest $request)
	{
		$comment = Comment::findOrFail($id);

        

		$comment->update($request->all());

		return redirect()->route(config('quickadmin.route').'.comment.index');
	}

	/**
	 * Remove the specified comment from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Comment::destroy($id);

		return redirect()->route(config('quickadmin.route').'.comment.index');
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
            Comment::destroy($toDelete);
        } else {
            Comment::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.comment.index');
    }

}

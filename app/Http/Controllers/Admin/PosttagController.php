<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Posttag;
use App\Http\Requests\CreatePosttagRequest;
use App\Http\Requests\UpdatePosttagRequest;
use Illuminate\Http\Request;

use App\Tag;
use App\Post;


class PosttagController extends Controller {

	/**
	 * Display a listing of posttag
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $posttag = Posttag::with("tag")->with("post")->get();

		return view('admin.posttag.index', compact('posttag'));
	}

	/**
	 * Show the form for creating a new posttag
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $tag = Tag::pluck("name", "id")->prepend('Please select', 0);
$post = Post::pluck("title", "id")->prepend('Please select', 0);

	    
	    return view('admin.posttag.create', compact("tag", "post"));
	}

	/**
	 * Store a newly created posttag in storage.
	 *
     * @param CreatePosttagRequest|Request $request
	 */
	public function store(CreatePosttagRequest $request)
	{
	    
		Posttag::create($request->all());

		return redirect()->route(config('quickadmin.route').'.posttag.index');
	}

	/**
	 * Show the form for editing the specified posttag.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$posttag = Posttag::find($id);
	    $tag = Tag::pluck("name", "id")->prepend('Please select', 0);
$post = Post::pluck("title", "id")->prepend('Please select', 0);

	    
		return view('admin.posttag.edit', compact('posttag', "tag", "post"));
	}

	/**
	 * Update the specified posttag in storage.
     * @param UpdatePosttagRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdatePosttagRequest $request)
	{
		$posttag = Posttag::findOrFail($id);

        

		$posttag->update($request->all());

		return redirect()->route(config('quickadmin.route').'.posttag.index');
	}

	/**
	 * Remove the specified posttag from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Posttag::destroy($id);

		return redirect()->route(config('quickadmin.route').'.posttag.index');
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
            Posttag::destroy($toDelete);
        } else {
            Posttag::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.posttag.index');
    }

}

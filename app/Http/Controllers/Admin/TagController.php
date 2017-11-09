<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Tag;
use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use Illuminate\Http\Request;



class TagController extends Controller {

	/**
	 * Display a listing of tag
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $tag = Tag::all();

		return view('admin.tag.index', compact('tag'));
	}

	/**
	 * Show the form for creating a new tag
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.tag.create');
	}

	/**
	 * Store a newly created tag in storage.
	 *
     * @param CreateTagRequest|Request $request
	 */
	public function store(CreateTagRequest $request)
	{
	    
		Tag::create($request->all());

		return redirect()->route(config('quickadmin.route').'.tag.index');
	}

	/**
	 * Show the form for editing the specified tag.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$tag = Tag::find($id);
	    
	    
		return view('admin.tag.edit', compact('tag'));
	}

	/**
	 * Update the specified tag in storage.
     * @param UpdateTagRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateTagRequest $request)
	{
		$tag = Tag::findOrFail($id);

        

		$tag->update($request->all());

		return redirect()->route(config('quickadmin.route').'.tag.index');
	}

	/**
	 * Remove the specified tag from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Tag::destroy($id);

		return redirect()->route(config('quickadmin.route').'.tag.index');
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
            Tag::destroy($toDelete);
        } else {
            Tag::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.tag.index');
    }

}

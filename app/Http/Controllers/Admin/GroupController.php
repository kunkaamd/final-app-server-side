<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Group;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Illuminate\Http\Request;



class GroupController extends Controller {

	/**
	 * Display a listing of group
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $group = Group::all();

		return view('admin.group.index', compact('group'));
	}

	/**
	 * Show the form for creating a new group
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.group.create');
	}

	/**
	 * Store a newly created group in storage.
	 *
     * @param CreateGroupRequest|Request $request
	 */
	public function store(CreateGroupRequest $request)
	{
	    
		Group::create($request->all());

		return redirect()->route(config('quickadmin.route').'.group.index');
	}

	/**
	 * Show the form for editing the specified group.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$group = Group::find($id);
	    
	    
		return view('admin.group.edit', compact('group'));
	}

	/**
	 * Update the specified group in storage.
     * @param UpdateGroupRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateGroupRequest $request)
	{
		$group = Group::findOrFail($id);

        

		$group->update($request->all());

		return redirect()->route(config('quickadmin.route').'.group.index');
	}

	/**
	 * Remove the specified group from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Group::destroy($id);

		return redirect()->route(config('quickadmin.route').'.group.index');
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
            Group::destroy($toDelete);
        } else {
            Group::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.group.index');
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\GroupPermisstion;
use App\Http\Requests\CreateGroupPermisstionRequest;
use App\Http\Requests\UpdateGroupPermisstionRequest;
use Illuminate\Http\Request;

use App\Group;
use App\Permission;


class GroupPermisstionController extends Controller {

	/**
	 * Display a listing of grouppermisstion
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $grouppermisstion = GroupPermisstion::with("group")->with("permission")->get();

		return view('admin.grouppermisstion.index', compact('grouppermisstion'));
	}

	/**
	 * Show the form for creating a new grouppermisstion
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $group = Group::pluck("name", "id")->prepend('Please select', 0);
$permission = Permission::pluck("name", "id")->prepend('Please select', 0);

	    
	    return view('admin.grouppermisstion.create', compact("group", "permission"));
	}

	/**
	 * Store a newly created grouppermisstion in storage.
	 *
     * @param CreateGroupPermisstionRequest|Request $request
	 */
	public function store(CreateGroupPermisstionRequest $request)
	{
	    
		GroupPermisstion::create($request->all());

		return redirect()->route(config('quickadmin.route').'.grouppermisstion.index');
	}

	/**
	 * Show the form for editing the specified grouppermisstion.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$grouppermisstion = GroupPermisstion::find($id);
	    $group = Group::pluck("name", "id")->prepend('Please select', 0);
$permission = Permission::pluck("name", "id")->prepend('Please select', 0);

	    
		return view('admin.grouppermisstion.edit', compact('grouppermisstion', "group", "permission"));
	}

	/**
	 * Update the specified grouppermisstion in storage.
     * @param UpdateGroupPermisstionRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateGroupPermisstionRequest $request)
	{
		$grouppermisstion = GroupPermisstion::findOrFail($id);

        

		$grouppermisstion->update($request->all());

		return redirect()->route(config('quickadmin.route').'.grouppermisstion.index');
	}

	/**
	 * Remove the specified grouppermisstion from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		GroupPermisstion::destroy($id);

		return redirect()->route(config('quickadmin.route').'.grouppermisstion.index');
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
            GroupPermisstion::destroy($toDelete);
        } else {
            GroupPermisstion::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.grouppermisstion.index');
    }

}

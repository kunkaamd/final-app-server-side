<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\UserGroup;
use App\Http\Requests\CreateUserGroupRequest;
use App\Http\Requests\UpdateUserGroupRequest;
use Illuminate\Http\Request;

use App\User;
use App\Group;


class UserGroupController extends Controller {

	/**
	 * Display a listing of usergroup
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $usergroup = UserGroup::with("user")->with("group")->get();

		return view('admin.usergroup.index', compact('usergroup'));
	}

	/**
	 * Show the form for creating a new usergroup
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::pluck("email", "id")->prepend('Please select', 0);
$group = Group::pluck("name", "id")->prepend('Please select', 0);

	    
	    return view('admin.usergroup.create', compact("user", "group"));
	}

	/**
	 * Store a newly created usergroup in storage.
	 *
     * @param CreateUserGroupRequest|Request $request
	 */
	public function store(CreateUserGroupRequest $request)
	{
	    
		UserGroup::create($request->all());

		return redirect()->route(config('quickadmin.route').'.usergroup.index');
	}

	/**
	 * Show the form for editing the specified usergroup.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$usergroup = UserGroup::find($id);
	    $user = User::pluck("email", "id")->prepend('Please select', 0);
$group = Group::pluck("name", "id")->prepend('Please select', 0);

	    
		return view('admin.usergroup.edit', compact('usergroup', "user", "group"));
	}

	/**
	 * Update the specified usergroup in storage.
     * @param UpdateUserGroupRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateUserGroupRequest $request)
	{
		$usergroup = UserGroup::findOrFail($id);

        

		$usergroup->update($request->all());

		return redirect()->route(config('quickadmin.route').'.usergroup.index');
	}

	/**
	 * Remove the specified usergroup from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		UserGroup::destroy($id);

		return redirect()->route(config('quickadmin.route').'.usergroup.index');
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
            UserGroup::destroy($toDelete);
        } else {
            UserGroup::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.usergroup.index');
    }

}

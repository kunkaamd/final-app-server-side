<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\UserPermission;
use App\Http\Requests\CreateUserPermissionRequest;
use App\Http\Requests\UpdateUserPermissionRequest;
use Illuminate\Http\Request;

use App\User;
use App\Permission;


class UserPermissionController extends Controller {

	/**
	 * Display a listing of userpermission
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $userpermission = UserPermission::with("user")->with("permission")->get();

		return view('admin.userpermission.index', compact('userpermission'));
	}

	/**
	 * Show the form for creating a new userpermission
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::pluck("name", "id")->prepend('Please select', 0);
$permission = Permission::pluck("name", "id")->prepend('Please select', 0);

	    
	    return view('admin.userpermission.create', compact("user", "permission"));
	}

	/**
	 * Store a newly created userpermission in storage.
	 *
     * @param CreateUserPermissionRequest|Request $request
	 */
	public function store(CreateUserPermissionRequest $request)
	{
	    
		UserPermission::create($request->all());

		return redirect()->route(config('quickadmin.route').'.userpermission.index');
	}

	/**
	 * Show the form for editing the specified userpermission.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$userpermission = UserPermission::find($id);
	    $user = User::pluck("name", "id")->prepend('Please select', 0);
$permission = Permission::pluck("name", "id")->prepend('Please select', 0);

	    
		return view('admin.userpermission.edit', compact('userpermission', "user", "permission"));
	}

	/**
	 * Update the specified userpermission in storage.
     * @param UpdateUserPermissionRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateUserPermissionRequest $request)
	{
		$userpermission = UserPermission::findOrFail($id);

        

		$userpermission->update($request->all());

		return redirect()->route(config('quickadmin.route').'.userpermission.index');
	}

	/**
	 * Remove the specified userpermission from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		UserPermission::destroy($id);

		return redirect()->route(config('quickadmin.route').'.userpermission.index');
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
            UserPermission::destroy($toDelete);
        } else {
            UserPermission::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.userpermission.index');
    }

}

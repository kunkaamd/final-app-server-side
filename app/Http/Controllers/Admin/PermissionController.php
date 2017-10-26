<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Permission;
use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\Request;



class PermissionController extends Controller {

	/**
	 * Display a listing of permission
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $permission = Permission::all();

		return view('admin.permission.index', compact('permission'));
	}

	/**
	 * Show the form for creating a new permission
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.permission.create');
	}

	/**
	 * Store a newly created permission in storage.
	 *
     * @param CreatePermissionRequest|Request $request
	 */
	public function store(CreatePermissionRequest $request)
	{
	    
		Permission::create($request->all());

		return redirect()->route(config('quickadmin.route').'.permission.index');
	}

	/**
	 * Show the form for editing the specified permission.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$permission = Permission::find($id);
	    
	    
		return view('admin.permission.edit', compact('permission'));
	}

	/**
	 * Update the specified permission in storage.
     * @param UpdatePermissionRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdatePermissionRequest $request)
	{
		$permission = Permission::findOrFail($id);

        

		$permission->update($request->all());

		return redirect()->route(config('quickadmin.route').'.permission.index');
	}

	/**
	 * Remove the specified permission from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Permission::destroy($id);

		return redirect()->route(config('quickadmin.route').'.permission.index');
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
            Permission::destroy($toDelete);
        } else {
            Permission::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.permission.index');
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\NotificationGroup;
use App\Http\Requests\CreateNotificationGroupRequest;
use App\Http\Requests\UpdateNotificationGroupRequest;
use Illuminate\Http\Request;

use App\Notification;
use App\Group;


class NotificationGroupController extends Controller {

	/**
	 * Display a listing of notificationgroup
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $notificationgroup = NotificationGroup::with("notification")->with("group")->get();

		return view('admin.notificationgroup.index', compact('notificationgroup'));
	}

	/**
	 * Show the form for creating a new notificationgroup
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $notification = Notification::pluck("title", "id")->prepend('Please select', 0);
$group = Group::pluck("name", "id")->prepend('Please select', 0);

	    
	    return view('admin.notificationgroup.create', compact("notification", "group"));
	}

	/**
	 * Store a newly created notificationgroup in storage.
	 *
     * @param CreateNotificationGroupRequest|Request $request
	 */
	public function store(CreateNotificationGroupRequest $request)
	{
	    
		NotificationGroup::create($request->all());

		return redirect()->route(config('quickadmin.route').'.notificationgroup.index');
	}

	/**
	 * Show the form for editing the specified notificationgroup.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$notificationgroup = NotificationGroup::find($id);
	    $notification = Notification::pluck("title", "id")->prepend('Please select', 0);
$group = Group::pluck("name", "id")->prepend('Please select', 0);

	    
		return view('admin.notificationgroup.edit', compact('notificationgroup', "notification", "group"));
	}

	/**
	 * Update the specified notificationgroup in storage.
     * @param UpdateNotificationGroupRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateNotificationGroupRequest $request)
	{
		$notificationgroup = NotificationGroup::findOrFail($id);

        

		$notificationgroup->update($request->all());

		return redirect()->route(config('quickadmin.route').'.notificationgroup.index');
	}

	/**
	 * Remove the specified notificationgroup from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		NotificationGroup::destroy($id);

		return redirect()->route(config('quickadmin.route').'.notificationgroup.index');
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
            NotificationGroup::destroy($toDelete);
        } else {
            NotificationGroup::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.notificationgroup.index');
    }

}

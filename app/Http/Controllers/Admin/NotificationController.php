<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Notification;
use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use Illuminate\Http\Request;

use App\User;


class NotificationController extends Controller {

	/**
	 * Display a listing of notification
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $notification = Notification::with("user")->get();

		return view('admin.notification.index', compact('notification'));
	}

	/**
	 * Show the form for creating a new notification
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::pluck("name", "id")->prepend('Please select', 0);

	    
	    return view('admin.notification.create', compact("user"));
	}

	/**
	 * Store a newly created notification in storage.
	 *
     * @param CreateNotificationRequest|Request $request
	 */
	public function store(CreateNotificationRequest $request)
	{
	    
		Notification::create($request->all());

		return redirect()->route(config('quickadmin.route').'.notification.index');
	}

	/**
	 * Show the form for editing the specified notification.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$notification = Notification::find($id);
	    $user = User::pluck("name", "id")->prepend('Please select', 0);

	    
		return view('admin.notification.edit', compact('notification', "user"));
	}

	/**
	 * Update the specified notification in storage.
     * @param UpdateNotificationRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateNotificationRequest $request)
	{
		$notification = Notification::findOrFail($id);

        

		$notification->update($request->all());

		return redirect()->route(config('quickadmin.route').'.notification.index');
	}

	/**
	 * Remove the specified notification from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Notification::destroy($id);

		return redirect()->route(config('quickadmin.route').'.notification.index');
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
            Notification::destroy($toDelete);
        } else {
            Notification::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.notification.index');
    }

}

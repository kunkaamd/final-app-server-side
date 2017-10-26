<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Test;
use App\Http\Requests\CreateTestRequest;
use App\Http\Requests\UpdateTestRequest;
use Illuminate\Http\Request;



class TestController extends Controller {

	/**
	 * Display a listing of test
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $test = Test::all();

		return view('admin.test.index', compact('test'));
	}

	/**
	 * Show the form for creating a new test
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.test.create');
	}

	/**
	 * Store a newly created test in storage.
	 *
     * @param CreateTestRequest|Request $request
	 */
	public function store(CreateTestRequest $request)
	{
	    
		Test::create($request->all());

		return redirect()->route(config('quickadmin.route').'.test.index');
	}

	/**
	 * Show the form for editing the specified test.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$test = Test::find($id);
	    
	    
		return view('admin.test.edit', compact('test'));
	}

	/**
	 * Update the specified test in storage.
     * @param UpdateTestRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateTestRequest $request)
	{
		$test = Test::findOrFail($id);

        

		$test->update($request->all());

		return redirect()->route(config('quickadmin.route').'.test.index');
	}

	/**
	 * Remove the specified test from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Test::destroy($id);

		return redirect()->route(config('quickadmin.route').'.test.index');
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
            Test::destroy($toDelete);
        } else {
            Test::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.test.index');
    }

}

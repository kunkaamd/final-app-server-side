<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Series;
use App\Http\Requests\CreateSeriesRequest;
use App\Http\Requests\UpdateSeriesRequest;
use Illuminate\Http\Request;

use App\User;


class SeriesController extends Controller {

	/**
	 * Display a listing of series
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $series = Series::with("user")->get();

		return view('admin.series.index', compact('series'));
	}

	/**
	 * Show the form for creating a new series
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::pluck("email", "id")->prepend('Please select', 0);

	    
	    return view('admin.series.create', compact("user"));
	}

	/**
	 * Store a newly created series in storage.
	 *
     * @param CreateSeriesRequest|Request $request
	 */
	public function store(CreateSeriesRequest $request)
	{
	    
		Series::create($request->all());

		return redirect()->route(config('quickadmin.route').'.series.index');
	}

	/**
	 * Show the form for editing the specified series.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$series = Series::find($id);
	    $user = User::pluck("email", "id")->prepend('Please select', 0);

	    
		return view('admin.series.edit', compact('series', "user"));
	}

	/**
	 * Update the specified series in storage.
     * @param UpdateSeriesRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateSeriesRequest $request)
	{
		$series = Series::findOrFail($id);

        

		$series->update($request->all());

		return redirect()->route(config('quickadmin.route').'.series.index');
	}

	/**
	 * Remove the specified series from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Series::destroy($id);

		return redirect()->route(config('quickadmin.route').'.series.index');
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
            Series::destroy($toDelete);
        } else {
            Series::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.series.index');
    }

}

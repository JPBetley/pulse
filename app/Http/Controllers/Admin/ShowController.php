<?php namespace WITR\Http\Controllers\Admin;

use WITR\Http\Requests\Admin\Show as Requests;
use WITR\Http\Controllers\Controller;
use WITR\Show;
use Input;
use File;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ShowController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('editor');
	}
	
	/**
	 * Display a listing of the Shows.
	 *
	 * @return Response
	 */
	public function index()
	{
		$shows = Show::orderBy('name', 'asc')->get();
		return view('admin.shows.index', ['shows' => $shows]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function new_show()
	{
		return view('admin.shows.create');
	}

	/**
	* Save the new Show.
	*
	*@return Response
	*/
	public function create(Requests\CreateRequest $request)
	{
		$show = new Show($request->except(['show_picture', 'slider_picture']));

		$showPicture = $request->file('show_picture');
		$show->uploadFile('show_picture', $showPicture);

		$sliderPicture = $request->file('slider_picture');
		$show->uploadFile('slider_picture', $sliderPicture);

		$show->save();
		return redirect()->route('admin.shows.index')
			->with('success', 'Show Saved!');
	}

	public function edit($id)
	{
		$show = Show::findOrFail($id);

		return view('admin.shows.edit', ['show' => $show]);
	}

	public function update(Requests\UpdateRequest $request, $id)
	{
		$show = Show::findOrFail($id);
		$show->fill($request->except(['show_picture', 'slider_picture']));

		if ($request->hasFile('show_picture')) 
		{
			$showPicture = $request->file('show_picture');
			$show->uploadFile('show_picture', $showPicture);
		}

		if ($request->hasFile('slider_picture')) 
		{
			$sliderPicture = $request->file('slider_picture');
			$show->uploadFile('slider_picture', $sliderPicture);
		}

		$show->save();
		return redirect()->route('admin.shows.index')
			->with('success', 'Show Saved!');
	}

	public function delete($id)
	{
		$show = Show::findOrFail($id);
		File::delete(public_path() . '/img/shows/' . $show->show_picture);
		File::delete(public_path() . '/img/slider/' . $show->slider_picture);
		Show::destroy($id);
		return redirect()->route('admin.shows.index')
			->with('success', 'Show Deleted!');
	}
}

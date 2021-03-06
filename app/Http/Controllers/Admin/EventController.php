<?php namespace WITR\Http\Controllers\Admin;

use WITR\Http\Requests\Admin\Event as Requests;
use WITR\Http\Controllers\Controller;
use WITR\Event;
use Carbon\Carbon;
use Input;
use File;

use Illuminate\Http\Request;

class EventController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('editor');
	}
	
	/**
	 * Display a listing of the Events.
	 *
	 * @return Response
	 */
	public function index()
	{
		$events = Event::where('type', 'SLIDER')->orderBy('date', 'desc')->get();
		return view('admin.events.index', ['events' => $events]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function new_event()
	{
		return view('admin.events.create');
	}

	/**
	* Save the new Event
	*
	* @return Response
	*/
	public function create(Requests\CreateRequest $request)
	{
		$input = $request->all();
		$event = new Event($input);
		$event->date = Carbon::createFromFormat('m/d/Y', $input['date']);
		$event->type = 'SLIDER';
		$file = $request->file('picture');
		$event->uploadFile('picture', $file);
		$event->save();
		return redirect()->route('admin.events.index')
			->with('success', 'Event Saved!');
	}

	public function edit($id)
	{
		$event = Event::findOrFail($id);

		return view('admin.events.edit', ['event' => $event]);
	}

	public function update(Requests\UpdateRequest $request, $id)
	{
		$event = Event::findOrFail($id);
		$event->fill($request->except(['date', 'picture']));

		if ($request->hasFile('picture'))
		{
			$file = $request->file('picture');
			$event->uploadFile('picture', $file);
		}

		$date = Carbon::createFromFormat('m/d/Y', $request->input('date'));
		$event->date = $date;

		$event->save();
		return redirect()->route('admin.events.index')
			->with('success', 'Event Saved!');
	}

	public function delete($id)
	{
		$event = Event::findOrFail($id);
		File::delete(public_path().'/img/events/'.$event->picture);
		Event::destroy($id);
		return redirect()->route('admin.events.index')
			->with('success', 'Event Deleted!');
	}

}

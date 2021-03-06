<?php namespace WITR\Http\Controllers\Admin;

use WITR\Http\Requests\Admin\AlbumReview as Requests;
use WITR\Http\Controllers\Controller;
use WITR\AlbumReview;
use File;
use Carbon\Carbon;

class AlbumReviewController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('editor');
	}

	/**
	 * Display a listing of the Album Reviews.
	 *
	 * @return Response
	 */
	public function index()
	{
		$reviews = AlbumReview::orderBy('band_name', 'asc')->get();
		return view('admin.reviews.index', ['reviews' => $reviews]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function new_review()
	{
		return view('admin.reviews.create');
	}

	/**
	* Save the new Album Review.
	*
	*@return Response
	*/
	public function create(Requests\CreateRequest $request)
	{
		$review = new AlbumReview($request->except('img_name'));

		$file = $request->file('img_name');
		$review->uploadFile('img_name', $file);

		$review->save();
		return redirect()->route('admin.reviews.index')
			->with('success', 'Album Review Saved!');
	}

	public function edit($id)
	{
		$review = AlbumReview::findOrFail($id);

		return view('admin.reviews.edit', ['review' => $review]);
	}

	public function update(Requests\UpdateRequest $request, $id)
	{
		$review = AlbumReview::findOrFail($id);
		$review->fill($request->except('img_name'));
		
		if ($request->hasFile('img_name')) 
		{
			$file = $request->file('img_name');
			$review->uploadFile('img_name', $file);
		}

		$review->save();
		return redirect()->route('admin.reviews.index')
			->with('success', 'Album Review Saved!');
	}

	public function delete($id)
	{
		$review = AlbumReview::findOrFail($id);
		File::delete(public_path() . '/img/albums/' . $review->img_name);
		AlbumReview::destroy($id);
		return redirect()->route('admin.reviews.index')
			->with('success', 'Album Review Deleted!');
	}

}

@extends('layouts.master')

@section('content')
<div class="general_wrap border">
	<div class="admin_section">
		<h2>Edit Album Review</h2>
			{!! Form::model($review,['method' => 'put', 'route' => ['admin.reviews.update', $review->id], 'file' => true]) !!}
				<br>
				<div>
          {!! Form::label('band_name', 'Band Name:') !!}
          {!! Form::text('band_name') !!}
        </div>
        <div>
          {!! Form::label('album_name', 'Album Name:') !!}
          {!! Form::text('album_name') !!}
        </div>
        <div>
          {!! Form::label('img_name', 'Album Image: (Note: Pictures should be of size 310x310)') !!}
          {!! Form::file('img_name') !!}
        </div>
        <div>
          {!! Form::label('review', 'Album Review:') !!}
          {!! Form::textarea('review') !!}
        </div>
				<div>
        <table>
				<tr>
          <td>{!! Form::submit('Update Review') !!}
              {!! Form::close() !!} </td>

          <td>{!! Form::open(['method' => 'delete', 'route' => ['admin.reviews.delete', $review->id]]) !!}
              {!! Form::submit('Delete Review') !!}
              {!! Form::close() !!} </td>
        </tr>
        </table>
				</div>
	</div>
</div>
@stop
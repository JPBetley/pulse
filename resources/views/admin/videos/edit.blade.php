@extends('layouts.master')

@section('content')
<div class="general_wrap border">
	<div class="admin_section">
		<h2>Edit Video Review</h2>
		@include('shared.validation-messages')
		{!! Form::model($video,['method' => 'put', 'route' => ['admin.videos.update', $video->id]]) !!}
			<br>
			<div>
				{!! Form::label('artist', 'Artist:') !!}
				{!! Form::text('artist') !!}
			</div>
			<div>
				{!! Form::label('album', 'Album:') !!}
				{!! Form::text('album') !!}
			</div>
			<div>
				{!! Form::label('song', 'Song:') !!}
				{!! Form::text('song') !!}
			</div>
			<div>
				{!! Form::label('url_tag', 'URL Link Copy:') !!}
				{!! Form::text('url_tag') !!}
			</div>
			<div>
				{!! Form::label('review', 'Video Review:') !!}
				{!! Form::textarea('review') !!}
			</div>
			{!! Form::submit('Update Review') !!}
		{!! Form::close() !!} </td>

		{!! Form::open(['method' => 'delete', 'route' => ['admin.videos.delete', $video->id], 'class' => 'delete-form']) !!}
				{!! Form::submit('Delete Review') !!}
		{!! Form::close() !!}
	</div>
</div>
@stop
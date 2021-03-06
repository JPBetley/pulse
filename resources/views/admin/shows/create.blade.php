@extends('layouts.master')

@section('content')
<div class="general_wrap border">
	<div class="admin_section">
		<h2>Add New Show</h2>
		@include('shared.validation-messages')
		{!! Form::open(array('route' => 'admin.shows.create.save', 'files' => true)) !!}
			<br>
			<div>
				{!! Form::label('name', 'Show Name:') !!}
				{!! Form::text('name') !!}
			</div>
			<div>
				{!! Form::label('description', 'Show Description:') !!}
				{!! Form::textarea('description') !!}
			</div>
			<div>
				{!! Form::label('show_picture', 'Show Picture: (Note: Pictures should be of size 150x150)') !!}
				{!! Form::file('show_picture') !!}
			</div>
			<div>
				{!! Form::label('slider-input', 'Slider Picture: (Note: Pictures shoule be of size 670x344') !!}
				{!! Form::file('slider_picture', [ 'id' => 'slider-input' ]) !!}
			</div>
			<div>
				<div>
				  {!! Form::label('style', 'Styles:') !!}
				  {!! Form::textarea('style', 'position: absolute; top: 20px; left: 20px; font-size: 44px;', [ 'id' => 'style-input' ]) !!}
				</div>
				<div style="position: relative; height: 344px; margin-bottom: 10px">
					<div id="style-display" class="message" style="position: absolute; top: 20px; left: 20px; font-size: 44px;">Tomorrow 11 - 12 AM</span></div>
					<div>
						<img id="slider-image" class="newsimg border" src="#">
					</div>
				</div>
		  	</div>
			<div>
				{!! Form::submit('Save Show') !!}
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop

@section('scripts')
<script type="text/javascript" src="{{ secure_asset('js/slider-style.js') }}"></script>
<script type="text/javascript">

	$(function() {
		SliderStyle.init();

		var $form = $('form');
		$form.on('submit', validate); 
	  
		function validate(e) {
			$('.error-message').remove();
			var $input = $('input[type=file]');
			$input.each(function() {
				if ($(this).val().length == 0) {
					e.preventDefault();
					$(this).after('<div class="error-message">File Input Required</div>');
				}
			});
	    }
	});

</script>
@stop
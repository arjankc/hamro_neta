@extends('admin._layouts.default')

@section('main')

	<h2>Create new post</h2>

	@include('admin._partials.notifications')

	{{ Form::open(array('route' => 'admin.posts.store', 'files' => true)) }}

		<div class="control-group">
			{{ Form::label('title', 'Title') }}
			<div class="controls">
				{{ Form::text('title') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('slug', 'URL Slug in English (compulsary)') }}
			<div class="controls">
				{{ Form::text('slug') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('content', 'Content') }}
			<div class="controls">
				{{ Form::textarea('content') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('image', 'Image') }}

			<div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
					<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
				</div>
				<div>
					<span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>{{ Form::file('image') }}</span>
					<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('post_type', 'Post Type') }}
			<div class="controls">
				{{ Form::select('post_type', ['updates'=>'Updates', 'results'=>'Results', 'post'=>'News', 'voice-of-people'=>'Voice of People']) }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
			<!-- <a href="{{ URL::route('admin.posts.index') }}" class="btn btn-large">Cancel</a> -->
		</div>

	{{ Form::close() }}

@stop

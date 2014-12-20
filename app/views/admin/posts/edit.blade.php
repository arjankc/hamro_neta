@extends('admin._layouts.default')

@section('main')

	<h2>Edit post</h2>

	@include('admin._partials.notifications')

	{{ Form::model($post, array('method' => 'put', 'route' => array('admin.posts.update', $post->id), 'files' => true)) }}

		<div class="control-group">
			{{ Form::label('title', 'Title') }}
			<div class="controls">
				{{ Form::text('title') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('slug', 'URL Slug in English (optional)') }}
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
					@if ($post->image)
						<a href="<?php echo URL::to($post->image); ?>"><img src="{{ URL::to($post->image) }}" alt=""></a>
					@else
						<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
					@endif
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

		<div class="control-group">
			{{ Form::label('tags', 'Tags') }}
			<div class="controls">
				{{ Form::textarea('tags') }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.posts.index') }}" class="btn btn-large">Cancel</a>
		</div>

	{{ Form::close() }}

@stop

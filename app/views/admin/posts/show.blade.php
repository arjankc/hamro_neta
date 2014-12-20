@extends('admin._layouts.default')

@section('main')
	<h2>Display post</h2>

	<hr>

	<h3>{{ $post->title }}</h3>
	<h5>@ {{ $post->created_at }}</h5>
	{{ nl2br($post->content) }}

	@if ($post->image)
		<hr>
		<figure><img src="{{ URL::to($post->image) }}" alt=""></figure>
	@endif
@stop

@extends('admin._layouts.default')

@section('main')

	<h1>
		posts <a href="{{ URL::route('admin.posts.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add new post</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th width="5%">#</th>
				<th width="50%">Title</th>
				<th width="10%">Type</th>
				<th width="25%">When</th>
				<th width="10%"><i class="icon-cog"></i></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($posts as $post)
				<tr>
					<td width="5%">{{ $post->id }}</td>
					<td width="50%"><a href="{{ URL::route('admin.posts.show', $post->id) }}">{{ Str::limit($post->title, 45) }}</a></td>
					<td width="10%">{{ $post->post_type }}</td>
					<td width="15%">{{ $post->created_at }}</td>
					<td width="10%">
						<a href="{{ URL::route('admin.posts.edit', $post->id) }}" class="btn btn-success btn-mini pull-left">Edit</a>

						{{ Form::open(array('route' => array('admin.posts.destroy', $post->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
							<button type="submit" href="{{ URL::route('admin.posts.destroy', $post->id) }}" class="btn btn-danger btn-mini">Delete</butfon>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@stop

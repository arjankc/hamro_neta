@extends('site._layouts.main')

@section('content')

    <div class="ajax-replace">
        @include('site.posts.show-partial')
    </div>
@stop


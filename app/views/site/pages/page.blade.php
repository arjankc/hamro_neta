@extends('site._layouts.main')

@section('content')

    <div class="ajax-replace">
    	@include('site.pages.'. $page)
    </div>
@stop


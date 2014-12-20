@extends('site._layouts.main')

@section('content')

    <div>
        <h1>Top Political Parties Favoured By Users</h1>
    </div>
    <ul id="leaders">

        @foreach ($parties as $party)
            <li>
                <div id="holder">
                    <a href="{{  URL::route('parties.show', $party->id) }}"><img src="{{ URL::to($party->logo) }}" alt=""></a>
                    <span class="name">{{ $party->name }}</span>
                </div>
            </li>
        @endforeach

        <div class="clearBoth"></div>
    </ul>

    {{ $parties->links() }}

@stop

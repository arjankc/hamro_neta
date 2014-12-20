@if (Route::is('parties.index'))
    <div>
        <h1>All Political Parties</h1>
    </div>
@endif

<div id="page-title" style="display:none">{{ $title }}</div>
<div id="leaders">
    @foreach ($parties as $party)
        <li>
            <div id="holder" class="ajax">
                <a href="{{  URL::route('parties.show', $party->id) }}"><img src="{{ URL::to($party->logo) }}" alt=""></a>
                <a href="{{  URL::route('parties.show', $party->id) }}"><span class="name">{{ $party->name }}</span> </a><br>
            </div>
        </li>
    @endforeach
</div>

<div class="clearBoth"></div>

<div class="ajax">
    {{ $parties->links() }}
</div>

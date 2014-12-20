<div id="search_input_div">

    @if (Route::is('search'))
        <!-- <h1>Search The Candidates</h1> -->
        <!-- <h1 style="color:red;">Search Election Results</h1> -->
        {{-- Form::open(['url'=>'search', 'method'=>'GET', 'id'=>'searchForm']) --}}
    @else
        {{-- Form::open(['route'=>'candidates.results', 'method'=>'GET', 'id'=>'searchForm']) --}}
    @endif
    <h1 style="color:red;" class="floatLeft">Search Election Results</h1>
    <div style="font-size:18px;display:none;" class="floatRight"><strong><a href="{{ URL::to('updates') }}" style="color:red;">लाईभ अपडेट्स हेर्न यहाँ क्लिक गर्नुहोस्</a></strong></div>
    <div class="clearBoth"></div>
    {{ Form::open(['url'=>'search', 'method'=>'GET', 'id'=>'searchForm']) }}
        {{ Form::text('name', (isset($input)) ? $input['name'] : '', ['placeholder'=> 'Candidate Name (उम्मेदवारको नाम)', 'size'=>48]) }}

        {{ Form::select('party', Party::all_list(), (isset($input)) ? $input['party'] : '', ['id'=>'party-id', 'class'=>'chosen-select']) }}

        {{ Form::select('district', Party::districts(), (isset($input)) ? $input['district'] : '', ['class'=>'chosen-select']) }}

        {{ Form::text('area', (isset($input)) ? $input['area'] : '', ['placeholder'=>'Area', 'size'=>3]) }}

        {{ Form::submit('Search', ['id'=>'submitSearch']) }}
    {{ Form::close() }}
</div>

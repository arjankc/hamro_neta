@extends('admin._layouts.default')

@section('main')
    <h2>Edit votes</h2>

    @include('admin._partials.notifications')

    <div class="container">
        <h3>Search The Candidates</h3>
        {{ Form::open(['url'=>'admin/candidates', 'method'=>'GET', 'id'=>'searchForm']) }}

            <div class="control-group">
                {{ Form::text('name', (isset($input)) ? $input['name'] : '', ['size'=>48]) }}

                {{ Form::select('party', Party::all_list(), (isset($input)) ? $input['party'] : '', ['id'=>'party-id', 'class'=>'chosen-select']) }}

                {{ Form::select('district', Party::districts(), (isset($input)) ? $input['district'] : '', ['class'=>'chosen-select']) }}

                {{ Form::text('area', (isset($input)) ? $input['area'] : '', ['placeholder'=>'Area', 'style'=>'width:100px;']) }}

                <button type="submit" class="btn btn-default">Search</button>
            </div>

        {{ Form::close() }}
    </div>

    @if (isset($candidates))
        <h2 id="search-h2">
            Search Result for : All the candidates
            @if ($input['name'] != '')
                named {{ Str::title(str_replace('%', ' ', $input['name'])) }}
            @endif
            @if ($input['party'] != 0)
                of {{ Party::name($input['party']) }}
            @endif
            @if ($input['district'] != '0')
                from {{ $input['district'] }}
                @if ($input['area'] != '')
                    - {{ $input['area'] }}
                @endif
            @endif
            @if ($input['category'] != 0)
                in the {{ $input['category'] }} category
            @endif
        </h2>
        <br>

        @if ($candidates->getTotal() == 0)
            No search results found
        @endif

        <table style="clear: both" class="table table-bordered table-striped" id="user">
            <thead>
                <td width="35%"><b>Candidate Name (उम्मेदवारको नाम)</b></td>
                <td width="40%"><b>पार्टीको नाम</b></td>
                <td width="25%"><b>Number of actual votes</b></td>
            </thead>
            <tbody>
                @foreach ($candidates as $candidate)
                    <tr>
                        <td width="35%">{{ $candidate->name_en }} ({{ $candidate->name_ne }})</td>
                        <td width="40%">{{ Party::name($candidate->party, 'en') }} ({{ Party::name($candidate->party, 'ne') }})</td>
                        <td width="25%">
                            <input type="hidden" name="hiddenID" value="{{ $candidate->id }}">
                            <a data-title="Enter votes" data-pk="{{ $candidate->id }}" data-type="text" class="votes" href="#" class="editable editable-click" style="display: inline;">{{ $candidate->actual_votes }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="ajax">
            {{ $candidates->appends(['name' => $input['name'], 'party' => $input['party'], 'district' => $input['district'], 'area' => $input['area'], 'category' => $input['category']])->links() }}
        </div>
    @endif

@stop

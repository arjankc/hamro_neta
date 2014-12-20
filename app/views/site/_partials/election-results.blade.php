<div id="page-title" style="display:none">{{ $title }}</div>

<h2 id="search-h2">
    Election results of all the candidates
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

@if (empty($candidates))
    No search results found
@endif

<table style="clear: both" class="table table-bordered table-striped" id="user">
    <thead>
        <tr>
            <th width="15%">District - Area</th>
            <th width="30%">Candidate Name (उम्मेदवारको नाम)</th>
            <th width="40%">राजनीतिक पार्टी</th>
            <th width="15%">Number of votes</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($candidates as $candidate)
            @if (($candidate->district == "Kathmandu" && $candidate->area == 1) || ($candidate->district == "Manang" && $candidate->area == 1))
                @if ($candidate->actual_votes != NULL)
                    <tr>
                        <td width="15%" class="ajax">
                            {{ HTML::link(URL::to('candidates/results?district=' . $candidate->district . '&area=' . $candidate->area), "$candidate->district - $candidate->area") }}
                        </td>
                        <td width="30%">{{ HTML::link(URL::to('candidates/' . $candidate->id), $candidate->name_en . ' (' . $candidate->name_ne . ')') }}</td>
                        <td width="40%">{{ Party::name($candidate->party, 'ne') }}</td>
                        <td width="15%">{{ $candidate->actual_votes }}</td>
                    </tr>
                @endif
            @endif
        @endforeach
    </tbody>
</table>

<div class="ajax">
    @if (method_exists($candidates, 'appends'))
        {{ $candidates->appends(['name' => $input['name'], 'party' => $input['party'], 'district' => $input['district'], 'area' => $input['area'], 'category' => $input['category']])->links() }}
    @endif
</div>

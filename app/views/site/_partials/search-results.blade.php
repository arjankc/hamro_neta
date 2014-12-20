@if (isset($candidates))
    <h2 id="search-h2">
        Election Results
        @if ($input['name'] != '')
            for candidate named {{ Str::title(str_replace('%', ' ', $input['name'])) }}
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

    @include('site._partials.candidates-list')

@endif

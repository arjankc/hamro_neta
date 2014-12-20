@if (Route::is('candidates.index'))
    <div>
        <h1>Top Candidates Favoured By Users</h1>
    </div>
@endif

<div id="page-title" style="display:none">{{ $title }}</div>
<ul id="leaders">
    @foreach ($candidates as $candidate)
        <?php
            $news = Post::where('title', '=', $candidate->district . ' ' . $candidate->area)
                            ->orderBy('updated_at', 'DESC')
                            ->first();
        ?>
        <li>
            <div id="holder">
                <a href="{{  URL::route('candidates.show', $candidate->id) }}">
                    <img src="{{ URL::to($candidate->photo) }}" alt="" width=220 height=285>
                </a>
                <span class="name">{{ $candidate->name_en }}</span> <br>
                <div class="voteCount">
                    @if ($candidate->actual_votes)
                        Votes <br> <span>{{ $candidate->actual_votes }}</span>
                    @else
                        Votes <br> <span>N/A</span>
                    @endif
                </div>
                <div class="overView">
                    <div class="spans">
                        <span class="appointedAt">{{ $candidate->district }} - {{ $candidate->area }}</span> <br>
                        <span class="partyName">{{ Party::name($candidate->party) }}</span>
                    </div>
                </div>

                <ul class="CastVote">
                    @if (Sentry::check())
                        {{-- Form::open(['url' => 'candidates/vote', 'POST']) --}}
                            {{-- Form::hidden('id', $candidate->id) --}}

                            {{-- Form::submit('Cast Vote', ['class'=>'link']) --}}
                        {{-- Form::close() --}}
                    @else
                        <!-- <li><a href="{{ URL::to('candidates/vote') }}">Cast Vote</a></li> -->
                    @endif
                    <li class="ajax"><a href="{{ URL::route('candidates.show', $candidate->id) }}">Profile</a></li>
                    @if (!isset($news) || $news->post_type != 'results')
                        <li><a href="#">मतगणना <br> जारी</a></li>
                    @elseif($news->post_type == 'results')
                        <?php
                            // $max_votes = Candidate::where('district', '=', $candidate->district)
                            //                         ->where('area', '=', $candidate->area)
                            //                         ->max('actual_votes');
                            if ($candidate->victory) {
                                echo '<li><a href="#">विजयी</a></li>';
                            } else {
                                echo '<li><a href="#">पराजित</a></li>';
                            }
                        ?>
                    @endif
                    @if (User::is_admin())
                        <li class="ajax">
                            {{ HTML::link(URL::to("candidates/{$candidate->id}/edit"), 'Edit') }}
                        </li>
                    @endif
                </ul>
            </div>
        </li>
    @endforeach

    <div class="clearBoth"></div>

    <div class="ajax">
        @if (Route::is('search'))
            {{ $candidates->appends(['name' => $input['name'], 'party' => $input['party'], 'district' => $input['district'], 'area' => $input['area'], 'category' => $input['category']])->links() }}
        @elseif (!Route::is('candidates.index'))
            {{ $candidates->links() }}
        @endif
    </div>
</ul>

<style>
    .link {
        background: none repeat scroll 0 0 #E8E8E8;
        border: medium none;
        color: #0a49d8;
        font-family: segoeuib;
        text-transform: uppercase;
        width: 100px;
        padding: 10px;
        cursor: pointer;
        margin: 0 0 10px 0;
    }
    .link:hover {
        background: #c2c0c0;
        color: #1c1c1c;
    }
</style>

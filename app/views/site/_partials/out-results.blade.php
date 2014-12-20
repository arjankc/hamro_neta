<div id="page-title" style="display:none">{{ $title }}</div>
<div>
    <h1>Winners of Constituent Assembly Election 2070 BS</h1>
</div>
<div class="clearBoth"></div>
<ul id="leaders">
    @foreach ($posts as $post)
        <?php
            // dd(explode(' ', $post->title));
            try {
                if (strpos($post->title, 'Dang Deukhuri') !== FALSE) {
                    $post->title = str_replace('Dang Deukhuri', 'Dang', $post->title);
                }

                list($district, $area) = explode(' ', $post->title);
                if ($district == 'Dang') {
                    $district = 'Dang Deukhuri';
                }
                $candidate = Candidate::where('district', '=', $district)
                                    ->where('area', '=', $area)
                                    ->where('actual_votes', '<>', '')
                                    ->where('actual_votes', '<>', 0)
                                    ->orderBy('actual_votes', 'DESC')
                                    ->first();
            } catch ( ErrorException $e) {
                $candidate = [];
            }
        ?>
        @if ($candidate)
            <li>
                <div id="holder">
                    <a href="{{  URL::route('candidates.show', $candidate->id) }}">
                        <img src="{{ URL::to($candidate->photo) }}" alt="" width=220 height=285>
                    </a>
                    <span class="name">{{ $candidate->name_en }}</span> <br>
                    <div class="voteCount">
                        Votes <br> <span>{{ $candidate->actual_votes }}</span>
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
                        @if (User::is_admin())
                            <li class="ajax">
                                {{ HTML::link(URL::to("candidates/{$candidate->id}/edit"), 'Edit') }}
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif
    @endforeach
    <div class="clearBoth"></div>
    <div class="ajax">
        {{ $posts->links() }}
    </div>
</ul>

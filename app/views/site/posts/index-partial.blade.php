<div id="page-title" style="display:none">{{ $title }}</div>
<div id="terms_conditions">
    @if (Route::is('news.search'))
        <h1>Search Results</h1>
    @else
        <h1>{{ $title }}</h1>
    @endif
    <div class="floatRight">
        @if (strpos(Route::getCurrentRoute()->getPath(), 'results') !== FALSE)
            <h2><a href="{{ URL::to('updates') }}" style="color:red;">लाईभ अपडेट्स हेर्न यहाँ किलक गर्नुहोस्</a></h2>
        @else
            <h2><a href="{{ URL::to('results') }}" style="color:red;">प्रकाशित नतिजा हेर्न यहाँ किलक गर्नुहोस्</a></h2>
        @endif
    </div>
    <div id="holder_post" class="floatLeft">
        @foreach ($posts as $post)
            <div id="post_inde">
                <h2>
                    @if (strpos(Route::getCurrentRoute()->getPath(), 'voice-of-people') !== FALSE)
                        <a href="{{ URL::to('voice-of-people/' . $post->slug) }}">{{ $post->title }}</a>
                    @elseif (strpos(Route::getCurrentRoute()->getPath(), 'updates') !== FALSE || strpos(Route::getCurrentRoute()->getPath(), 'results') !== FALSE)
                        <a href="#">{{ $post->title }}</a>
                    @else
                        <a href="{{ URL::to('news/' . $post->slug) }}">{{ $post->title }}</a>
                    @endif
                </h2>
                <p>
                    @if (strpos(Route::getCurrentRoute()->getPath(), 'voice-of-people') !== FALSE)
                        {{ Str::limit($post->content, 220) }}
                        <a href="{{ URL::to('voice-of-people/' . $post->slug) }}">Read More</a>
                    @elseif (strpos(Route::getCurrentRoute()->getPath(), 'updates') !== FALSE || strpos(Route::getCurrentRoute()->getPath(), 'results') !== FALSE)

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

                                $results = Candidate::where('district', '=', $district)
                                                    ->where('area', '=', $area)
                                                    ->where('actual_votes', '<>', '')
                                                    ->where('actual_votes', '<>', 0)
                                                    ->orderBy('actual_votes', 'DESC')
                                                    ->get();
                            } catch ( ErrorException $e) {
                                $results = [];
                            }
                        ?>

                        @if (!$results || sizeof($results)==0)
                            {{ nl2br($post->content) }}
                        @else
                            @foreach ($results as $result)
                                {{ HTML::link('candidates/' . $result->id, trim($result->name_ne)) }} ({{ trim(Party::name($result->party, 'ne')) }}) - {{ $result->actual_votes }} <br>
                            @endforeach

                            @if (strpos($post->content, '**') !== FALSE)
                                <br>
                                {{ nl2br($post->content) }}
                            @endif
                        @endif
                    @else
                        {{ Str::limit($post->content, 220) }}
                        <a href="{{ URL::to('news/' . $post->slug) }}">Read More</a>
                    @endif
                </p>
            </div>
        @endforeach
    </div>

    @include('site.posts.sidebar')

    <div class="clearBoth"></div>

    <div class="ajax">
        {{ $posts->links() }}
    </div>

</div>

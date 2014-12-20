<div id="page-title" style="display:none">{{ $title }}</div>
<div id="terms_conditions">

    <div id="holder_post" class="floatLeft">
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
            <div>
                @if ($post->image)
                    <div class="floatLeft" style="margin:0px 20px 20px 0px"><img src="{{ URL::to($post->image) }}" alt="" width="200px"></div>
                @endif
                @if (strpos(Route::getCurrentRoute()->getPath(), 'voice-of-people') !== FALSE)
                    {{ $post->content }}
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

                        <br><br><br>
                        <h2><a href="{{ URL::to('updates') }}" style="color:red;">लाईभ अपडेट्स हेर्न यहाँ किलक गर्नुहोस्</a></h2>
                    @endif
                @else
                    {{ $post->content }}
                @endif
            </div>

        </div>

        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'hamroneta'; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
    </div>

    @include('site.posts.sidebar')

    <div class="clearBoth"></div>

</div>

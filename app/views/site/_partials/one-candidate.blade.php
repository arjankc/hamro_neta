<div id="page-title" style="display:none">{{ $title }}</div>
<h1 class="candidate_h1">
    {{ $candidate->name_ne }} <br>
    <span class="subtitle">{{ $candidate->name_en }}</span>
</h1>

<div id="profile_box">
    <div id="party_info" class="floatRight">

        <?php $party = Party::find($candidate->party); ?>
        @if ($candidate->party != 133)
            <h2>Party Information</h2>
            <div class="ajax">
                <a href="{{ URL::to('parties/' . $party->id) }}">
                    {{ HTML::image($party->logo, $party->name, ['width'=>120, 'title'=>$party->name]) }}
                </a>
                <a href="{{ URL::to('parties/' . $party->id) }}">
                    {{ HTML::image($party->vote_sign, $party->name, ['width'=>120, 'title'=>$party->name]) }}
                </a>
            </div>
            <span class="photo marg">दल चिन्ह</span>
            <span class="photo">दल चुनाव चिन्ह</span>
        @endif

        <div id="suggested_candi">
            <h2>Other candidates from {{ $candidate->district }}-{{ $candidate->area }}</h2>
            <ul id="leaders" class="ajax">
                @foreach ($others as $other)
                    <li>
                        <div id="holder">
                            <a href="{{ URL::route('candidates.show', $other->id) }}" class="floatLeft">{{ HTML::image($other->photo, $other->name_ne, ['width'=>90, 'height'=>90]) }}</a>
                            <p class="floatRight">
                                <span class="name">{{ HTML::link(URL::route('candidates.show', $other->id), $other->name_ne) }}</span> <br>
                                @if ($other->actual_votes)
                                    <span>{{ $other->actual_votes }}</span> Votes <br>
                                @endif
                                {{ Party::name($other->party, 'ne') }} <br>
                                <br>
                            </p>
                        </div>
                    </li>
                @endforeach
                <div class="clearBoth"></div>
            </ul>
            <div class="clearBoth"></div>
            <span class="ajax view_all2">{{ HTML::link('search?district=' . $candidate->district . '&area=' . $candidate->area, 'View all candidates from ' . $candidate->district . '-' . $candidate->area) }}</span>

        </div>


    </div>

    <div id="canid_main" class="floatLeft">
        <div id="picture_div" class="floatLeft">
            {{ HTML::image($candidate->photo, $candidate->name_en) }}
            @if (Sentry::check())
                {{-- Form::open(['url' => 'candidates/vote', 'POST']) --}}
                    {{-- Form::hidden('id', $candidate->id) --}}

                    {{-- Form::submit('Cast Vote', ['id'=>'vote_but', 'class'=>'link']) --}}
                {{-- Form::close()--}}
            @else
                <!-- <br> -->
                <!-- <a href="{{ URL::to('candidates/vote') }}">Cast Vote</a> -->
            @endif
            @if (User::is_admin())
                <br>
                <div class="ajax">
                    {{ HTML::link(URL::to("candidates/{$candidate->id}/edit"), 'Edit Profile', ['class'=>'link']) }}
                </div>
            @endif
            <div class="clearBoth"></div>
        </div>

        <div id="info_can_div" class="ajax floatLeft">
            <label for="">उमेर :</label><span>{{ $candidate->age }}</span>
            <label for="">लिंग :</label>
            <span>
                @if ($candidate->gender == 'Male')
                    पुरुष
                @elseif ($candidate->gender == 'Female')
                    महिला
                @elseif ($candidate->gender == 'Third Gender')
                    तेस्रो लिंगी
                @else
                    {{ $candidate->gender }}
                @endif
            </span>
            <label for="">पार्टी :</label><span>
                @if ($candidate->party == 133)
                    {{--Display all independent candidates instead of party information--}}
                    <a href="{{ URL::to('search?party=133') }}">{{ Party::name($candidate->party, 'ne') }}</a>
                @else
                    <a href="{{ URL::to('parties/' . $party->id) }}">{{ Party::name($candidate->party, 'ne') }}</a>
                @endif
            </span>
            @if ($candidate->contact)
                <label for="">सम्पर्क :</label><span>{{ $candidate->contact }}</span>
            @endif
            @if ($candidate->education)
                <label for="">शिक्षा :</label><span>{{ $candidate->education }}</span>
            @endif
            @if ($candidate->actual_votes)
                <label for="" class="vote_this">प्राप्त मत :</label>
                <span class="vote_this">{{ $candidate->actual_votes }}</span>
            @endif
            <label>नतिजा :</label>
            <span>
                @if($candidate->victory)
                    विजयी
                @else
                    <?php
                        $news = Post::where('title', '=', $candidate->district . ' ' . $candidate->area)
                                        ->orderBy('updated_at', 'DESC')
                                        ->first();
                    ?>
                    @if (isset( $news) )
                        @if ($news->post_type != 'results')

                        @else
                            पराजित
                        @endif
                    @endif
                @endif
            </span>
            @if ($candidate->address)
                <label for="">जन्म जिल्ला :</label><span>{{ $candidate->address }}</span>
            @endif
            <label for="">निर्वाचन क्षेत्र :</label><span>{{ $candidate->district }}-{{ $candidate->area }}</span>
            <label for="">चुनाव चिन्ह :</label>
            @if ($candidate->party == 133)
                {{--independent candidates have their own voting sign--}}
                <span>{{ HTML::image($candidate->vote_sign, $party->name, ['width'=>120, 'title'=>$party->name]) }}</span>
            @else
                <span>{{ HTML::image($party->vote_sign, $party->name, ['width'=>120, 'title'=>$party->name]) }}</span>
            @endif
            <div class="clearBoth"></div>
        </div>



        <div id="political_history" class="floatLeft">
            @if ($candidate->history)
                <h3>थप विवरण </h3>
                <p>
                    {{ nl2br($candidate->history) }}
                </p>
                <p>
                    <div class="fb-comments" data-href="{{URL::full()}}" data-numposts="5"></div>
                </p>
            @endif
        </div>

        <div id="holder_post" class="ajax floatLeft">
            <?php //$posts = Post::is_candidate($candidate->id) ?>
            @if (0)
                <h2>News related to {{ $candidate->name_en }}</h2>
                @foreach ($posts as $post)
                    <div id="post_inde">
                        <?php $post = Post::find($post) ?>
                        <h2>{{ HTML::link(URL::to('news/' . $post->id), $post->title) }}</h3>
                        <p>
                            {{ Str::limit($post->content, 100) }}
                            {{ HTML::link(URL::to('news/' . $post->id), 'Read More') }}
                        </p>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="clearBoth"></div>

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

    <div class="clearBoth"></div>

    <div class="clearBoth"></div>

</div>

<style>
    .link {
        background: none repeat scroll 0 0 #fff;
        border: medium none;
        color: #0a49d8;
        font-family: segoeuib;
        text-transform: uppercase;
        cursor: pointer;
        font-weight: normal;
    }
    .link:hover {
        color: #1c1c1c;
    }
</style>

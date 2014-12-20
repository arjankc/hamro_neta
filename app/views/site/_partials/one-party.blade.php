<div id="holder_party">
    <div id="page-title" style="display:none">{{ $title }}</div>
    <h1 class="candidate_h1">
        {{ $party->name_ne }} <br>
        <span class="subtitle">{{ $party->name }}</span>
    </h1>
    <div id="profile_box" class="floatRight">
        <div id="party_info" class="floatRight">
            <a href="{{ URL::to('parties/' . $party->id) }}">
                {{ HTML::image($party->logo, $party->name_ne, ['width'=>120, 'title'=>$party->name_ne]) }}
            </a>
            <a href="{{ URL::to('parties/' . $party->id) }}">
                {{ HTML::image($party->vote_sign, $party->name_ne, ['width'=>120, 'title'=>$party->name_ne]) }}
            </a>
            <span class="photo marg">दल चिन्ह</span>
            <span class="photo">दल चुनाव चिन्ह</span>
            <p class="ajax">
                <a href="{{ URL::to('search?party=' . $party->id) }}">सबै उम्मेदवारहरू</a>
            </p>
            <p class="ajax">
                <a href="{{ URL::to('parties') }}">थप दलहरू </a>
            </p>
        </div>
    </div>

    <div id="canid_main" class="floatLeft">
        <div id="picture_div" class="floatLeft">
            {{ HTML::image($party->logo, $party->name_ne, ['title'=>$party->name_ne]) }}
            <div class="clearBoth"></div>
        </div>

        <div id="info_can_div" class="floatLeft">
            <label for="">मुख्य कार्यालय :</label><span>{{ $party->headquarter }}</span>
            <label for="">अध्यक्ष्य / सभापति :</label><span>{{ $party->president }}</span>
            @if ($party->established && $party->established!='*')
                <label for="">स्थापना मिति :</label><span>{{ $party->established }}</span>
            @endif
            @if ($party->philosophy && $party->philosophy!='*')
                <label for="">सिद्धान्त :</label><span>{{ $party->philosophy }}</span>
            @endif
            @if ($party->contact_website && $party->contact_website!='*')
                <label for="">सम्पर्क वेब्सैट :</label><span>{{ $party->contact_website }}</span>
            @endif
            @if ($party->contact_number && $party->contact_number!='*')
                <label for="">सम्पर्क नम्बर :</label><span>{{ $party->contact_number }}</span>
            @endif
            @if ($party->contact_person && $party->contact_person!='*')
                <label for="">सम्पर्क व्यक्ति :</label><span>{{ $party->contact_person }}</span>
            @endif

            <div class="clearBoth"></div>

        </div>

        <div class="share_addthis">

        </div>


        <div class="clearBoth"></div>

            <div id="suggested_parties">
                <h2>Other Parties</h2>
                <ul id="parties_ul">

                    @foreach (Party::take(4)->orderBy(DB::raw('RAND()'))->get() as $party)
                        <li class="ajax">
                            <a href="{{ URL::to('parties/' . $party->id) }}">{{ HTML::image($party->logo, $party->name, ['title'=>$party->name]) }}</a>
                            <p>
                                <span class="name">{{ $party->name }}</span> <br>
                                <a href="{{ URL::to('parties/' . $party->id) }}">View Profile</a>
                            </p>
                        </li>
                    @endforeach
                    <div class="clearBoth"></div>
                </ul>
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

    <div class="clearBoth"></div>

</div>


<div class="clearBoth"></div>

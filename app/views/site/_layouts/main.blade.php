<!DOCTYPE html>
<!--
       _____ __                         ______          __        __      __
      / ___// /__________  ____  ____ _/ ____/___  ____/ /__     / /___ _/ /_  _____
      \__ \/ __/ ___/ __ \/ __ \/ __ `/ /   / __ \/ __  / _ \   / / __ `/ __ \/ ___/
     ___/ / /_/ /  / /_/ / / / / /_/ / /___/ /_/ / /_/ /  __/  / / /_/ / /_/ (__  )
    /____/\__/_/   \____/_/ /_/\__, /\____/\____/\__,_/\___/  /_/\__,_/_.___/____/
                              /____/
 -->
<html>
    <head>
        <meta charset="UTF-8">
        @if (Route::is('candidates.results'))
            <meta property="description" content="Constituent Assembly 2070 BS / 2013 AD Results Nepal | संबिधानसभाको निर्वाचन २०७० को नतिजा नेपाल"/>
            <meta property="og:description" content="Constituent Assembly 2070 BS / 2013 AD Results Nepal | संबिधानसभाको निर्वाचन २०७० को नतिजा नेपाल"/>
        @elseif (isset($candidate))
            @if ($candidate->history == '')
                <meta property="description" content="हाम्रो नेता डट कम (hamroneta.com) २०७० साल मंगसिर ४ देखि हुन गइरहेको संबिधानसभाको निर्वाचनको उमेदवारहरुको एउटा 'नमुना अनलाईन निर्वाचन पोल' हो | यो वेबसाईट उमेदवारहरुको बारेमा जानकारी उपलब्ध गराउने एउटा बृहत डाइरेक्टरी हो |"/>
                <meta property="og:description" content="हाम्रो नेता डट कम (hamroneta.com) २०७० साल मंगसिर ४ देखि हुन गइरहेको संबिधानसभाको निर्वाचनको उमेदवारहरुको एउटा 'नमुना अनलाईन निर्वाचन पोल' हो | यो वेबसाईट उमेदवारहरुको बारेमा जानकारी उपलब्ध गराउने एउटा बृहत डाइरेक्टरी हो |"/>
            @else
                <meta name="description" content="{{ $candidate->name_ne }} - {{ Str::limit($candidate->history , 230)}}"/>
                <meta name="og:description" content="{{ $candidate->name_ne }} - {{ Str::limit($candidate->history, 230) }}"/>
            @endif
        @elseif (isset($post))
            <meta name="description" content="{{ Str::limit($post->candidate , 250)}}"/>
            <meta name="og:description" content="{{ Str::limit($post->candidate, 250) }}"/>
        @else
            <meta property="description" content="हाम्रो नेता डट कम (hamroneta.com) २०७० साल मंगसिर ४ देखि हुन गइरहेको संबिधानसभाको निर्वाचनको उमेदवारहरुको एउटा 'नमुना अनलाईन निर्वाचन पोल' हो | यो वेबसाईट उमेदवारहरुको बारेमा जानकारी उपलब्ध गराउने एउटा बृहत डाइरेक्टरी हो |"/>
            <meta property="og:description" content="हाम्रो नेता डट कम (hamroneta.com) २०७० साल मंगसिर ४ देखि हुन गइरहेको संबिधानसभाको निर्वाचनको उमेदवारहरुको एउटा 'नमुना अनलाईन निर्वाचन पोल' हो | यो वेबसाईट उमेदवारहरुको बारेमा जानकारी उपलब्ध गराउने एउटा बृहत डाइरेक्टरी हो |"/>
        @endif

        @if (isset($candidate))
            <meta property="og:image" content="{{ URL::to($candidate->photo) }}">
        @elseif (isset($party))
            <meta property="og:image" content="{{ URL::to($party->logo) }}">
        @elseif (isset($post))
            <meta property="og:image" content="{{ URL::to($post->image) }}">
        @elseif (Route::is('candidate-results'))
        @else
            <meta property="og:image" content="{{ URL::to('assets/images/hamroneta_logo.png')}}">
        @endif
        <!-- <meta property="og:site_name" content="Hamro Neta"/>
        <meta property="og:title" content="{{ $title }} :: Hamro Neta"/>
        <meta property="og:image" content="{{ URL::to('assets/images/hamroneta_logo.png')}}">
        <meta property="og:url" content="{{ URL::full() }}"> -->
        <title>{{ $title }} :: Hamro Neta</title>
        {{ Basset::show('public.css') }}

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-45505007-1', 'hamroneta.com');
            ga('send', 'pageview');
        </script>
        
	
    </head>
    <body>
        <div id="fb-root"></div>
        <!-- <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=141756512690609";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script> -->

        <div id="wrapper">

            <div id="menuDiv">
                <a href="#modal" id="menuDivBut">Click Away</a>
                <p>Show/Hide Menu</p>

            </div>
            <div id="modal">
                <ul>
                    <li class="ajax">
                        <a href="{{ URL::to('search?party=0') }}" id="leader">Leaders</a>
                        <div>
                            Candidates
                        </div>
                    </li>
                    <li class="ajax">
                        <a href="{{ URL::to('parties') }}" id="parties">Parties</a>
                        <div>
                            Parties
                        </div>
                    </li>
                    <li>
                        <li class="ajax">
                            <a href="{{ URL::to('testimonials') }}" id="testi">Testimonials</a>
                            <div>
                                Testimonials
                            </div>
                        </li>
                    </li>
                    @if (Sentry::check())
                        <li class="ajax">
                            <a href="{{ URL::to('users/me') }}" id="account">My Account</a>
                            <div>
                                My Account
                            </div>
                        </li>
                        <li>
                            <a href="{{ URL::to('users/logout') }}" id="logout">Log-out</a>
                            <div>
                                Log Out
                            </div>
                        </li>
                    @endif

                </ul>
            </div>

            <div id="container">

                <div id="header">
                    <div id="topbar">
                        <ul class="ajax floatRight">
                            <li><a href="{{URL::to('voice-of-people')}}">जनताको आवाज</a>|</li>
                            <li><a href="{{URL::to('know_us')}}">About us</a>|</li>
                            <li><a href="{{URL::to('testimonials')}}">Testimonials</a>|</li>
                            <li><a href="{{URL::to('hamro_neta')}}">FAQ</a></li>
                        </ul>
                        <div class="clearBoth"></div>
                    </div>

                    <div id="logo_div" class="ajax floatLeft">
                        <a href="{{ URL::to('site') }}"><img src="{{URL::to('assets/images/logo.jpg')}}" alt=""></a>
                    </div>

                    @if (Sentry::check())
                        <div id="account_info_div" class="ajax floatRight">
                            <div id="account_info" class="floatRight">
                                You are Logged In as <br>
                                <a href="{{ URL::to('users/me') }}">{{ Profile::username() }}</a>
                            </div>

                            <div id="imageHolder" class="floatleft">
                                <a href="{{ URL::to('users/me') }}">{{ HTML::image(Profile::photo(), '', ['width'=>58, 'height'=>58]) }}</a>
                            </div>
                            <div class="clearBoth"></div>
                        </div>
                    @else
                        <div id="account_info_div" class="floatRight">
                            <div id="account_info" class="floatRight">
                                Welcome, <strong>Guest</strong>! <br>
                                Please {{ HTML::link(URL::to('login'), 'log-in') }} to participate in voting.
                            </div>

                            <div id="imageHolder" class="floatleft">
                                <a href="{{ URL::to('/') }}">{{ HTML::image('img/guest.jpg', '', ['width'=>58, 'height'=>58]) }}</a>
                            </div>
                            <div class="clearBoth"></div>
                        </div>
                    @endif


                    <div id="account_info_div2" class="ajax floatRight">
                            <a href="{{ URL::to('help_us') }}">{{ HTML::image('assets/images/help.jpg', '')}}</a>
                            <div class="clearBoth"></div>
                    </div>


                    <div class="clearBoth"></div>
                    <!-- <a href="{{ URL::to('candidates/graph') }}" id="statistics_load">तथ्यांक</a> -->
                </div>

                <div id="bodyContainer" class="home">
                    @include('site._partials.search')

                    {{ Notification::showAll() }}

                    @if (Session::has('register_message'))
                        <div class='alert alert-success'>{{ Session::get('register_message') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class='alerts alert-error'>
                            {{ implode('<br>', $errors->all()) }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
            <div class="clearBoth"></div>

            <div class="ajax seeMoreDiv">
                    <a href="{{ URL::to('search?party=0') }}"><img src="{{URL::to('assets/images/seemore_but.jpg')}}" alt=""></a>
            </div>
            <div class="clearBoth"></div>
        </div>

        <div id="campaignInfoDiv">

            <div id="footerWrapper">


                <div id="askblood">
                    	<a href="http://askblood.org" target="_blank">
                    		<img src="{{URL::to('assets/images/askblood.jpg')}}">
                    	</a>
                    	<a href="#" target="_blank">
                    		<img src="{{URL::to('assets/images/onenepal.jpg')}}">
                    	</a>
                    	<a href="http://www.facebook.com/nsknirnaya" target="_blank">
                    		<img src="{{URL::to('assets/images/nsk.jpg')}}">
                    	</a>
                    	<div class="clearBoth"></div>
              </div>

                <div id="footer">

                    <ul id="policies" class="ajax floatLeft">
                        <li><a href="{{URL::to('privacy') }}">Privacy Policies</a>|</li>
                        <li><a href="{{URL::to('terms') }}">Terms &amp; Conditions</a>|</li>
                        <li><a href="{{URL::to('feedback') }}">Provide Feedback</a></li>
                    </ul>

                    <div id="developed_info" class="floatRight">
                        Developed by <a href="http://strongcodelabs.com/" target="_blank">Strongcode labs</a>
                    </div>
                    <div class="clearBoth"></div>
                </div>
            </div>

        </div>


        {{ Basset::show('public.js') }}

        <script>
            var disqus_shortname = 'hamroneta'; // required: replace example with your forum shortname
            $(document).ready(function(){

            	$("#testimonial_tab").css('visibility', 'visible');
		$( "#testimonial_tab" ).tabs({active: 2});

                $("#menuDivBut").pageslide({ direction: "right", modal: true });
                $(".profile").pageslide({ direction: "left", modal: true });
                $( 'a[href="#"]' ).click( function(e) {
                      e.preventDefault();
                });

                var s = document.createElement('script'); s.async = true;
                s.type = 'text/javascript';
                s.src = '//' + disqus_shortname + '.disqus.com/count.js';
                (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);

            });
        </script>

        <!-- AddThis Smart Layers BEGIN -->
        <!-- Go to http://www.addthis.com/get/smart-layers to customize -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f86a7d52c4f96c9"></script>
        <script type="text/javascript">
          addthis.layers({
            'theme' : 'transparent',
            'share' : {
              'position' : 'right',
              'numPreferredServices' : 4
            },
            'follow' : {
              'services' : [
                {'service': 'facebook', 'id': 'hamronetanepal'}
              ]
            }
          });
        </script>
        <!-- AddThis Smart Layers END -->

        <script>
            $(document).ready(function(){
                $("#menuDivBut").pageslide({ direction: "right", modal: true });
                // $("#statistics_load").colorbox({iframe:true, width:"700px", height:"550px"});
            });
        </script>

    </body>
</html>
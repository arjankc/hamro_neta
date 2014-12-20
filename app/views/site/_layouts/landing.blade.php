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
        <meta property="og:description" content="हाम्रो नेता डट कम (hamroneta.com) २०७० साल मंगसिर ४ देखि हुन गइरहेको संबिधानसभाको निर्वाचनको उमेदवारहरुको एउटा 'नमुना अनलाईन निर्वाचन पोल' हो | यो वेबसाईट उमेदवारहरुको बारेमा जानकारी उपलब्ध गराउने एउटा बृहत डाइरेक्टरी हो |"/>
        @if (isset($candidate))
            <meta property="og:image" content="{{ URL::to($candidate->photo) }}">
        @elseif (isset($party))
            <meta property="og:image" content="{{ URL::to($party->logo) }}">
        @else
            <meta property="og:image" content="{{ URL::to('assets/images/hamroneta_logo.png')}}">
        @endif
        <!-- <meta property="og:site_name" content="Hamro Neta"/>
        <meta property="og:title" content="{{ $title }} :: Hamro Neta"/>
        <meta property="og:url" content="{{ URL::full() }}">
        <meta property="og:image" content="{{ URL::to('assets/images/hamroneta_logo.png')}}"> -->
        <title>{{ $title }} :: Hamro Neta</title>
        {{ Basset::show('landing.css') }}

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
        <div id="wrapper">

            @if ($errors->any())
                <div id="message">
                    {{ implode('<br>', $errors->all()) }}
                </div>
            @endif

            <div id="header">
                <div id="topbar">
                    <ul>
                        <li><a href="{{ URL::to('terms') }}">Terms &amp; Conditions   </a></li>
                        <li><a href="{{ URL::to('privacy') }}">Privacy Policies  </a></li>
                        <li><a href="{{ URL::to('feedback') }}">Feedback</a></li>
                    </ul>
                </div>
                <div id="cover">
                    <div id="logo_quote" class="floatLeft">
                        <img src="{{ URL::to('assets/images/hamroneta_logo.png') }}" alt="">
                        <div id="quote">
                            <p>
                                Democracy is two wolves and a lamb voting on what to have for lunch. Liberty is a well-armed lamb contesting the vote!
                            </p>
                            <span>-Benjamin Franklin</span>
                        </div>
                    </div>

                    <div id="login_div" class="floatRight">
                        <div id="tabs">
                            <ul>
                                <li><a href="#register">Register</a></li>
                                <li><a href="#login">Login</a></li>
                            </ul>
                            <a href="{{ URL::to('login/fb') }}"><img src="{{ URL::to('assets/images/fbconnect.png') }}" alt=""></a>
                            <div id="register">
                                @include('site.users.signup')
                            </div>
                            <div id="login">
                                @include('site.users.login')
                            </div>
                            {{ HTML::link(URL::to('site'), 'Visit Site without signing in', ['id' => 'visit']) }}
                        </div>
                    </div>

                </div>
            </div>
            <div id="container">
                <div id="sectionOne">
                    <h1>हाम्रो नेता डट कम के हो ? </h1>
                    <p>
                        हाम्रो नेता डट कम (hamroneta.com) २०७० साल मंगसिर ४ देखि हुन गइरहेको संबिधानसभाको निर्वाचनको उमेदवारहरुको एउटा 'नमुना अनलाईन निर्वाचन पोल' हो | यो वेबसाईट उमेदवारहरुको बारेमा जानकारी उपलब्ध गराउने एउटा बृहत डाइरेक्टरी हो |
                        <a href="{{URL::to('hamro_neta')}}">थप पढ्नुहोस् </a>
                    </p>
                </div>
                <div id="sectionTwo">
                    <h1>हामी को हौ ? </h1>
                    <p>
                        इन्टरनेट र प्रबिधि मार्फत् आममानिसहरुलाई हामीसंग भएको जानकारी , ज्ञान, सिप र शिक्षा बाँडेर देशलाई सकारात्मक परिवर्तन गर्न चाहने विभिन्न पृष्ठभूमि बाट आएका जिम्मेवार व्यावसायिक युवा समूह हौँ | सुरुमा हामी तिन जना : विजय खड्का, क्षितिज रिमाल र सुबोध दहाल मात्र थियौं तर हाम्रो काम र सोचलाई समर्थन र सहयोग गर्दै साथ् दिने थुप्रै हातहरु थपिएर अहिले हामी पारस भण्डारी, अभिषेक पौडेल, संजीब आचार्य, मनोज घिमिरे गरी जम्मा ७ जना यस समूहमा पूर्णकालिन कार्य गर्दै आएका छौं |
                        <a href="{{URL::to('know_us')}}">थप पढ्नुहोस् </a>
                    </p>
                </div>
                <div id="sectionThree">
                    <h1>केहि तथ्यांकहरू </h1>
                    <div id="chartsection">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
            <div class="clearboth"></div>
            <div id="footer">
                <p>
                    Developed By <a href="http://www.strongcodelabs.com" target="_blank">Strongcode Labs</a>
                </p>
            </div>
        </div>

        <a href="#" class="scrollup">
            Goto<br>Top
        </a>

        {{ Basset::show('landing.js') }}
        <script>

            $(document).ready(function(){
                $(window).scroll(function(){
                    if ($(this).scrollTop() > 100) {
                        $('.scrollup').fadeIn();
                    } else {
                        $('.scrollup').fadeOut();
                    }
                });

                $('.scrollup').click(function(){
                    $("html, body").animate({ scrollTop: 0 }, 600);
                    return false;
                });

                $("#tabs").css('visibility', 'visible');
                $( "#tabs" ).tabs({active: 2});

                var line2 = {{ $chart }};

                    var plot2 = $.jqplot('chart', [line2], {
                      axes: {
                        xaxis: {
                          renderer: $.jqplot.CategoryAxisRenderer,
                          label: 'Name of the political party',
                          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                          tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                          tickOptions: {
                              // labelPosition: 'middle',
                              angle: 20
                          }

                        },
                        yaxis: {
                          label: 'Number of candidates',
                          labelRenderer: $.jqplot.CanvasAxisLabelRenderer
                        }
                      }
                    });

            });
        </script>



        


    </body>
</html>
@extends('site._layouts.main')

@section('content')

    <div class="ajax-replace">
        @include('site.posts.index-partial')
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

    <script type="text/javascript">
        var auto_refresh = setInterval(
        function () {
            if (typeof $ != 'undefined') {
                window.update_ajax = $('.ajax-replace').load(window.location.href).fadeIn("slow");
                $("#holder_post .ajax").first().css('background', '#eaeb6e');
            }
        }, 60000); // refresh every 10000 milliseconds
    </script>
@stop

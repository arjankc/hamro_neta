<div id="sidebar_cat" class="floatRight">
    <h2>Search</h2>
    <hr>
    <div id="search_post">
        @if (strpos(Route::getCurrentRoute()->getPath(), 'voice-of-people') !== FALSE)
            {{ Form::open(['route'=>'voice-of-people.search', 'method'=>'GET']) }}
        @elseif (strpos(Route::getCurrentRoute()->getPath(), 'updates') !== FALSE)
            {{ Form::open(['route'=>'updates.search', 'method'=>'GET']) }}
        @else
            {{ Form::open(['route'=>'news.search', 'method'=>'GET']) }}
        @endif
        {{ Form::open(['route'=>'news.search', 'method'=>'GET']) }}
            <input type="text" placeholder="Search Posts" name="query">
            <input type="submit" value="Search">
        {{ Form::close() }}
        <div class="clearBoth"></div>
    </div>
    <h2>Recent Posts</h2>
    <hr>
    <ul id="recent_posts">
        @foreach ($recent as $post)
            <li>
                <?php if ($post->post_type == 'post') {
                    $post->post_type = 'news';
                } ?>
                <a href="{{ URL::to($post->post_type . '/' . $post->slug) }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
</div>

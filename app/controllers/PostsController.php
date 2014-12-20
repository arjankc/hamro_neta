<?php

class PostsController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $voice_of_people = strpos(Route::getCurrentRoute()->getPath(), 'voice-of-people') !== FALSE;
        $updates = strpos(Route::getCurrentRoute()->getPath(), 'updates') !== FALSE;
        $results = strpos(Route::getCurrentRoute()->getPath(), 'results') !== FALSE;

        if ($voice_of_people) {
            $posts = Post::where('status', '=', 'public')
                            ->where('post_type', '=', 'voice-of-people')
                            ->orderBy('updated_at', 'DESC')
                            ->paginate(5);
        } else if ($updates) {
            $posts = Post::where('status', '=', 'public')
                            ->where('post_type', '=', 'updates')
                            ->orWhere('post_type', '=', 'results')
                            ->orderBy('updated_at', 'DESC')
                            ->paginate(25);
        } else if ($results) {
            $posts = Post::where('status', '=', 'public')
                            ->where('post_type', '=', 'results')
                            ->orderBy('updated_at', 'DESC')
                            ->paginate(25);
        } else {
            $posts = Post::where('status', '=', 'public')
                            ->where('post_type', '=', 'post')
                            ->orderBy('updated_at', 'DESC')
                            ->paginate(5);
        }

        $recent = $this->recent();

        if ($voice_of_people) {
            $title = 'जनताको आवाज';
        } else if ($updates) {
            $title = 'Live Updates';
        } else if ($results) {
            $title = 'प्रकाशित नतिजा';
        } else {
            $title = 'Latest News';
        }

        if (Request::ajax()) {
            return View::make('site.posts.index-partial')
                            ->with('title', $title)
                            ->with('posts', $posts)
                            ->with('recent', $recent);
        } else {
            return View::make('site.posts.index')
                            ->with('title', $title)
                            ->with('posts', $posts)
                            ->with('recent', $recent);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', '=', $slug)->first();

        if (!$post || $post->status != 'public') {
            App::abort('404');
        }
        $recent = $this->recent();

        if (Request::ajax()) {
            return View::make('site.posts.show-partial')
                            ->with('title', $post->title)
                            ->with('post', $post)
                            ->with('recent', $recent);
        } else {
            return View::make('site.posts.show')
                            ->with('title', $post->title)
                            ->with('post', $post)
                            ->with('recent', $recent);
        }
    }

    public function getSearch()
    {
        $query = Input::get('query', '');
        $query = strip_tags($query);

        $posts = Post::where('title', 'LIKE', "%$query%")
                        ->orWhere('content', 'LIKE', "%$query%")
                        ->paginate(10);
        $recent = $this->recent();

        if (Request::ajax()) {
            return View::make('site.posts.index-partial')
                            ->with('title', 'Search')
                            ->with('posts', $posts)
                            ->with('recent', $recent);
        } else {
            return View::make('site.posts.index')
                            ->with('title', 'Search')
                            ->with('posts', $posts)
                            ->with('recent', $recent);
        }
    }

    protected function recent()
    {
        $posts = Post::where('status', '=', 'public')
                        ->orderBy('title', 'ASC')
                        ->get();

        return $posts;
    }
}

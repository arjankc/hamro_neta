<?php namespace Admin;

use \Auth, \BaseController, \Form, \Input, \Redirect, \Sentry, \View, \Image, \Notification, \Post, \Str, \File, \Config, \URL;

class PostsController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::where('id', '>', 0)
                        ->orderBy('updated_at', 'DESC')
                        ->get();

        return View::make('admin.posts.index')
                    ->with('title', 'All Posts')
                    ->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.posts.create')
                    ->with('title', 'Create a new post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input              = Input::all();
        if ($input['slug'] == '') {
            $input['slug']  = Str::slug($input['title']);
        }
        $input['user_id']   = Sentry::getUser()->id;
        $input['post_type'] = (isset($input['post_type'])) ? $input['post_type'] : 'post';

        $post = new Post($input);

        if ($post->validates()) {
            if (Input::file('image')) {
                $post->image = $this->upload($input['image'], 'img/posts');
            }
            $post->save();
            Notification::success('The ' . $post->post_type . ' was saved.');
            return Redirect::route('admin.posts.index');
        }

        return Redirect::back()->withInput()->withErrors($post->errors);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // $posts = Post::where('post_type', '=', 'results')->get();

        // foreach ($posts as $post) {
        //     try {
        //         if (strpos($post->title, 'Dang Deukhuri') !== FALSE) {
        //             $post->title = str_replace('Dang Deukhuri', 'Dang', $post->title);
        //         }

        //         list($district, $area) = explode(' ', $post->title);
        //         if ($district == 'Dang') {
        //             $district = 'Dang Deukhuri';
        //         }

        //         $candidates = \Candidate::where('district', '=', $district)
        //                                 ->where('area', '=', $area)
        //                                 ->where('actual_votes', '<>', '')
        //                                 ->where('actual_votes', '<>', 0)
        //                                 ->orderBy('actual_votes', 'DESC')
        //                                 ->get();

        //         $count = 0;
        //         foreach ($candidates as $candidate) {
        //             if ($count == 0) {
        //                 $candidate->victory = true;
        //                 $count++;
        //             } else {
        //                 $candidate->victory = false;
        //             }
        //             $candidate->save();
        //         }
        //     } catch ( ErrorException $e) {
        //         $results = [];
        //     }
        // }
        return View::make('admin.posts.show')
                    ->with('title', 'A Post')
                    ->with('post', Post::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return View::make('admin.posts.edit')
                    ->with('title', 'Edit a post')
                    ->with('post', Post::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();

        $post = Post::find($id);

        // if ($post->validates()) {
            $post->title = $input['title'];
            $post->content = $input['content'];
            $post->slug = $input['slug'];
            $post->tags = $input['tags'];
            $post->post_type = (isset($input['post_type'])) ? $input['post_type'] : $post->post_type;

            if (Input::file('image')) {
                $post->image = $this->upload($input['image'], 'img/posts');
            } else {
                $post->image = 'dummy.jpg';
            }
            $post->save();

            if ($post->post_type == 'results') {
                try {
                    if (strpos($post->title, 'Dang Deukhuri') !== FALSE) {
                        $post->title = str_replace('Dang Deukhuri', 'Dang', $post->title);
                    }

                    list($district, $area) = explode(' ', $post->title);
                    if ($district == 'Dang') {
                        $district = 'Dang Deukhuri';
                    }

                    $candidates = \Candidate::where('district', '=', $district)
                                            ->where('area', '=', $area)
                                            ->where('actual_votes', '<>', '')
                                            ->where('actual_votes', '<>', 0)
                                            ->orderBy('actual_votes', 'DESC')
                                            ->get();

                    $count = 0;
                    foreach ($candidates as $candidate) {
                        if ($count == 0) {
                            $candidate->victory = true;
                            $count++;
                        } else {
                            $candidate->victory = false;
                        }
                        $candidate->save();
                    }
                } catch ( ErrorException $e) {
                    $results = [];
                }
            }
            Notification::success('The ' . $post->post_type . ' was saved.');
            return Redirect::route('admin.posts.index');
        // }

       // return Redirect::back()->withInput()->withErrors($post->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            Notification::error('The post was not found.');
        } else {
            if ($post->delete()) {
                Notification::success('The ' . $post->post_type . ' was deleted.');
            } else {
                Notification::error('The ' . $post->post_type . ' wasn\'t deleted.');
            }
        }

        return Redirect::route('admin.posts.index');
    }

    protected function upload($file, $dir = null)
    {
        if ($file) {
            // Generate random dir
            if ( ! $dir) $dir = str_random(8);

            // Get file info and try to move
            $destination = $dir;
            $filename    = $file->getClientOriginalName();
            // $file_ext    = File::extension($filename);
            $file_ext    = 'jpg';
            // dd($file_ext);
            $only_fname  = str_replace('.' . $file_ext, '', $filename);

            $count = 1;
            // To avoid replacing old files with the same name file name as present file
            while (File::exists($destination . '/' . $filename)) {
                $filename = $only_fname . '_' . $count . '.' . $file_ext;
                $count++;
            }

            $path     = Config::get('image.upload_dir') . '/' . $dir . '/' . $filename;
            $uploaded = $file->move($destination, $filename);

            if ($uploaded) {
                return $path;
            }
        }
    }
}

<?php

class CandidatesController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $candidates = Candidate::orderBy('actual_votes', 'DESC')
                                ->orderBy(DB::raw('RAND()'))
                                ->paginate(9);

        if (Request::ajax()) {
            // If the request is AJAX, return only the list of candidates without other html
            return View::make('site._partials.candidates-list')
                        ->with('title', 'Top Candidates')
                        ->with('candidates', $candidates);

        } else {
            return View::make('site.candidates.index')
                            ->with('title', 'Top Candidates')
                            ->with('candidates', $candidates);
        }
    }

    public function getAll()
    {
        $candidates = Candidate::orderBy('name_en', 'ASC')
                                ->paginate(9);

        if (Request::ajax()) {
            // If the request is AJAX, return only the list of candidates without other html
            return View::make('site._partials.candidates-list')
                            ->with('title', 'All Candidates')
                            ->with('candidates', $candidates);
        } else {
            return View::make('site.candidates.all')
                            ->with('title', 'All Candidates')
                            ->with('candidates', $candidates);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $candidate = Candidate::find($id);
        if (! isset($candidate)) {
            App::abort('404');
        }

        $others = Candidate::where('district', '=', $candidate->district)
                    ->where('area', '=', $candidate->area)
                    ->where('id', '<>', $id)
                    ->orderBy('actual_votes', 'DESC')
                    ->orderBy(DB::raw('RAND()'))
                    ->take(5)
                    ->get();

        if (Request::ajax()) {
            // If the request is AJAX, return only the list of candidates without other html
            return View::make('site._partials.one-candidate')
                        ->with('title', "{$candidate->name_en} (Candidate)")
                        ->with('candidate', $candidate)
                        ->with('others', $others);

        } else {
            return View::make('site.candidates.show')
                        ->with('title', "{$candidate->name_en} (Candidate)")
                        ->with('candidate', $candidate)
                        ->with('others', $others);
        }
    }

    public function getVote()
    {
        if (!Sentry::check())
        {
            return Redirect::to('login')
                                ->withErrors('Please log-in to participate in voting.');
        }
    }

    public function postVote()
    {
        $id = Input::get('id');
        $user_id = Sentry::getUser()->id;

        $candidate = Candidate::find($id);
        if (!$candidate) {
            App::abort('404');
        }

        $existing_vote = UserVote::where('user_id', '=', Sentry::getUser()->id)
                                    ->where('leader_id', '=', $id)
                                    ->first();

        if (Request::ajax()) {
            if ($existing_vote) {
                $message = "<div class='alert alert-error'>You have already voted for $candidate->name_en.</div>";
            } else {
                $this->vote($id, $user_id, $candidate);
                $message = "<div class='alert alert-success'>You have successfully voted for $candidate->name_en.<br> You can vote other candidates also.</div>";
            }

            return $message;
        } else {
            if ($existing_vote) {
                Notification::error("You have already voted for $candidate->name_en.");
            } else {
                $this->vote($id, $user_id, $candidate);
                Notification::success("You have successfully voted for $candidate->name_en.<br> You can vote other candidates also.");
            }

            return Redirect::back();
        }
    }

    protected function vote($id, $user_id, $candidate)
    {
        $user_vote = new UserVote(array(
                                'user_id'   => $user_id,
                                'leader_id' => $id
                            ));
        $user_vote->save();

        $candidate->vote = ($candidate->vote == '') ? 1 : $candidate->vote + 1;
        $candidate->save();
    }

    public function getGraph()
    {
        $results = Candidate::top_parties();

        return View::make('site.pages.graph')
                        ->with('title', 'Statistics')
                        ->with('results', $results);
    }

    public function edit($id)
    {
        // $user = Sentry::createUser(array(
        //     'email'       => 'admin2@strongcodelabs.com',
        //     'password'    => 'admin123strong',
        //     'first_name'  => 'The',
        //     'last_name'   => 'Administrator',
        //     'activated'   => 1,
        // ));

        // Assign user permissions
        // $userGroup = Sentry::findGroupById(2);
        // $user->addGroup($userGroup);

        $candidate = Candidate::find($id);

        if (Request::ajax()) {
            return View::make('site._partials.candidate-edit')
                            ->with('title', "Edit $candidate->name_en")
                            ->with('candidate', $candidate);
        } else {
            return View::make('site.candidates.edit')
                            ->with('title', "Edit $candidate->name_en")
                            ->with('candidate', $candidate);
        }
    }

    public function update($id)
    {
        $input = Input::all();
        $candidate = Candidate::find($id);
        $candidate->name_ne = $input['name_ne'];
        $candidate->name_en = $input['name_en'];
        $candidate->age = $input['age'];
        $candidate->gender = Str::title($input['gender']);
        $candidate->contact = $input['contact'];
        $candidate->education = $input['education'];
        $candidate->vote = $input['vote'];
        $candidate->address = $input['address'];
        $candidate->district = Str::title($input['district']);
        $candidate->area = $input['area'];
        $candidate->history = $input['history'];

        if (Input::file('image')) {
            $candidate->photo = $this->upload($input['image'], 'img/leader');
        }

        $candidate->save();

        Notification::success("You have successfully edited $candidate->name_en.");
        return Redirect::to('candidates/' . $id);
    }

    protected function upload($file, $dir = null)
    {
        if ($file) {
            // Generate random dir
            if ( ! $dir) $dir = str_random(8);

            // Get file info and try to move
            $destination = $dir;
            $filename    = $file->getClientOriginalName();
            $file_ext    = File::extension($filename);
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

    public function getResults()
    {
        $title = 'Constituent Assembly Election 2070 Results';

        $input['name']     = strip_tags(Input::get('name', ''));
        $input['party']    = strip_tags(Input::get('party', 0));
        $input['district'] = strip_tags(Input::get('district', '0'));
        $input['category'] = strip_tags(Input::get('category', 0));
        $input['area']     = strip_tags(Input::get('area', ''));

        if ($input['district'] == '0') {
            $input['area'] = '';
        }

        if ($_GET) {
            // If there are any search parameters
            $candidates = Candidate::search($input, 'actual_votes', 100);
        } else {
            // If no search parameters, display all the winners from each sector
            // $candidates = Candidate::where('id', '>', 0)->paginate(240);

            // $candidates = Candidate::select(
            //                 DB::raw('district, area, name_en, name_ne, party, max(actual_votes) as maxvote')
            //             )
            //             ->groupBy(DB::raw('district, area'))
            //             ->paginate(240);

            $candidates = DB::select(DB::raw("SELECT id, district, area, name_en, name_ne, party, max( actual_votes ) AS max_votes FROM `leaders` GROUP BY district, area"));

            // select area, district, name_en, max(vote) as maxvote
            // from leaders
            // group by district, area;
        }

        if (Request::ajax()) {
            return View::make('site._partials.election-results')
                        ->with('title', $title)
                        ->with('input', $input)
                        ->with('candidates', $candidates);
        } else {
            return View::make('site.results')
                        ->with('title', $title)
                        ->with('input', $input)
                        ->with('candidates', $candidates);
        }
    }

}

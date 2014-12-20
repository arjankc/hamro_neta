<?php

class HomeController extends BaseController {

    public function getIndex()
    {
         if (Sentry::check()) {
            return Redirect::to('site');
        }
        $groups = Candidate::select(array('party', DB::raw('COUNT(*) `amount`')))
                                ->where('party', '>', 0)
                                ->groupBy('party')
                                ->orderBy('amount', 'DESC')
                                ->take(10)
                                ->get();

        $chart = '[';
        foreach ($groups as $g) {
            $chart .= '["' . Party::name($g->party, 'ne') . '", ' . $g->amount . '],';
        }
        $chart .= ']';

        return View::make('site._layouts.landing')
                    ->with('title', 'Home')
                    ->with('chart', $chart);
    }

    public function getSearch()
    {
        $title = 'Search Page';
        if ($_GET) {
            $input['name']     = strip_tags(Input::get('name', ''));
            $input['party']    = strip_tags(Input::get('party', 0));
            $input['district'] = strip_tags(Input::get('district', '0'));
            $input['category'] = strip_tags(Input::get('category', 0));
            $input['area']     = strip_tags(Input::get('area', ''));

            if ($input['district'] == '0') {
                $input['area'] = '';
            }

            if ($input['name']=='' && $input['party']==0 && $input['district']=='0' && $input['category']==0 && $input['area']=='') {
                $title = 'All Candidates';
            }

            return $this->search($input, $title);
        }

        if (Request::ajax()) {
            return View::make('site._partials.search')
                        ->with('title', $title);
        } else {
            return View::make('site.search')
                        ->with('title', $title);
        }
    }

    protected function search($input, $title='')
    {
        // $input = Input::all();
        $input['name'] = str_replace(' ', '%', $input['name']);

        $candidates = Candidate::search($input, 'victory', 9);

        $input['name'] = str_replace('%', ' ', $input['name']);

        if (Request::ajax()) {
            // If the request is AJAX, return only the list of candidates without other html
            return View::make('site._partials.search-results')
                            ->with('title', $title)
                            ->with('input', $input)
                            ->with('candidates', $candidates);

        } else {
            return View::make('site.search')
                        ->with('title', $title)
                        ->with('input', $input)
                        ->with('candidates', $candidates);
        }
    }

    public function getCandidateResults()
    {
        $posts = Post::where('status', '=', 'public')
                        ->Where('post_type', '=', 'results')
                        ->orderBy('updated_at', 'DESC')
                        ->paginate(15);

        if (Request::ajax()) {
            return View::make('site._partials.out-results')
                            ->with('title', 'Winners of Constituent Assembly Election 2070 BS')
                            ->with('posts', $posts);
        } else {
            return View::make('site.out-results')
                            ->with('title', 'Winners of Constituent Assembly Election 2070 BS')
                            ->with('posts', $posts);
        }
    }
}

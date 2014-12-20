<?php namespace Admin;

use \Auth, \BaseController, \Form, \Input, \Redirect, \Sentry, \View, \Image, \Notification, \Post, \Str, \File, \Config, \URL;

class CandidatesController extends BaseController {

    public function getCandidates()
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

            $candidates = \Candidate::search($input, 'actual_votes', 300);

            return View::make('admin.votes.edit-votes')
                            ->with('title', 'Edit Votes')
                            ->with('candidates', $candidates)
                            ->with('input', $input);
        } else {
            return View::make('admin.votes.edit-votes')
                            ->with('title', 'Edit Votes');
        }
    }

    public function postAddVote()
    {
        $candidate = \Candidate::find(Input::get('pk'));
        $votes = Input::get('value');

        $votes = $this->parseNepali(trim($votes));

        $candidate->actual_votes = $votes;
        $result = $candidate->save();

        $title = $candidate->district . ' ' . $candidate->area;
        $post = Post::where('title', '=', $title)->first();
        if ($post) {
            $post->updated_at = time();
            $post->save();
        } else {
            $post = Post::create (array(
                'title'     => $title,
                'content'   => 'हाम्रो नेता',
                'status'    => 'public',
                'post_type' => 'updates',
                'slug'      => Str::slug($title),
                'user_id'   => Sentry::getUser()->id,
            ));
        }
    }

    function parseNepali($str) {
        $str = str_replace('१', 1, $str);
        $str = str_replace('२', 2, $str);
        $str = str_replace('३', 3, $str);
        $str = str_replace('४', 4, $str);
        $str = str_replace('५', 5, $str);
        $str = str_replace('६', 6, $str);
        $str = str_replace('७', 7, $str);
        $str = str_replace('८', 8, $str);
        $str = str_replace('९', 9, $str);
        $str = str_replace('०', 0, $str);

        return $str;
    }
}

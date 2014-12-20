<?php

class Candidate extends BaseModel {
	protected $guarded = array();

	public static $rules = array();

    protected $table = 'leaders';

    public static function all_data()
    {
        $all_candidates = Candidate::take(20)->get() ;
        foreach ($all_candidates as $candidate) {
            $candidate->photo = URL::to($candidate->photo);
            unset($candidate->created_at);
            unset($candidate->updated_at);
            unset($candidate->vote);
            unset($candidate->other_district);
            unset($candidate->other_area);
        }
        return $all_candidates;
    }

    public static function name($id, $lang='en')
    {
        $candidate = Candidate::find($id);
        if (!$candidate) {
            return '';
        }
        return ($lang=='en') ? $candidate->name_en : $candidate->name_ne;
    }

    public static function votes($id)
    {
        $candidate = Candidate::find($id);
        if (!$candidate) {
            return '';
        }

        return ($candidate->vote=='') ? 0 : $candidate->vote;
    }

    public static function top_parties()
    {
        $results = DB::table('leaders')
                        ->select(DB::raw('party, sum(vote) as total_votes'))
                        ->where('vote', '<>', '')
                        ->groupBy('party')
                        ->orderBy('total_votes', 'DESC')
                        ->take(10)
                        ->get();

        $ret = [];
        foreach ($results as $result) {
            $ret[Party::name($result->party, 'ne')] = $result->total_votes;
        }
        // dd($ret);
        return $ret;
    }

    public static function search($input, $orderBy='vote', $paginate=null)
    {
        $GLOBALS['input']   = $input;
        $GLOBALS['orderBy'] = $orderBy;
        // dd($GLOBALS);
        $candidates = Candidate::where(function($query) {
                                $input = $GLOBALS['input'];
                                $query->where('name_en', 'LIKE', "%{$input['name']}%")
                                      ->orWhere('name_ne', 'LIKE', "%{$input['name']}%");
                            })
                            ->where(function($query) {
                                $input = $GLOBALS['input'];
                                if ($input['party'] != 0) {
                                    $query->where('party', '=', $input['party']);
                                }
                                if ($input['district'] != '0') {
                                    $query->where('district', '=', $input['district']);
                                }
                            })
                            ->where(function($query) {
                                $input = $GLOBALS['input'];
                                if ($input['category'] != '0') {
                                    $query->where('category', '=', $input['category']);
                                }
                            })
                            ->where(function($query) {
                                $input = $GLOBALS['input'];
                                if ($input['area'] != '') {
                                    $query->where('area', '=', $input['area']);
                                }
                            })
                            ->orderBy($GLOBALS['orderBy'], 'DESC')
                            ->orderBy('name_en', 'ASC')
                            ->paginate($paginate);

        return $candidates;
    }
}

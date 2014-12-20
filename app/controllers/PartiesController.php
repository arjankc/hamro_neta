<?php

class PartiesController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $parties = Party::paginate(9);

        if (Request::ajax()) {
            // If the request is AJAX, return only the list of parties without other html
            return View::make('site._partials.parties-list')
                        ->with('title', 'Top Parties')
                        ->with('parties', $parties);

        } else {
            return View::make('site.parties.index')
                            ->with('title', 'Top Parties')
                            ->with('parties', $parties);
        }
    }

    public function getAll()
    {
        $parties = Party::paginate(9);

        return View::make('site.parties.all')
                        ->with('title', 'All Parties')
                        ->with('parties', $parties);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $party = Party::find($id);

        if (!$party) {
            App::abort('404');
        }

        if (Request::ajax()) {
            // If the request is AJAX, return only the list of candidates without other html
            return View::make('site._partials.one-party')
                        ->with('title', "{$party->name} (Party)")
                        ->with('party', $party);
        } else {
            return View::make('site.parties.show')
                        ->with('title', "{$party->name} (Party)")
                        ->with('party', $party);
        }
    }
}

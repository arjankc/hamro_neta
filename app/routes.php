<?php

/*
       _____ __                         ______          __        __      __
      / ___// /__________  ____  ____ _/ ____/___  ____/ /__     / /___ _/ /_  _____
      \__ \/ __/ ___/ __ \/ __ \/ __ `/ /   / __ \/ __  / _ \   / / __ `/ __ \/ ___/
     ___/ / /_/ /  / /_/ / / / / /_/ / /___/ /_/ / /_/ /  __/  / / /_/ / /_/ (__  )
    /____/\__/_/   \____/_/ /_/\__, /\____/\____/\__,_/\___/  /_/\__,_/_.___/____/
                              /____/
*/

Route::get('/', function() {
    return Redirect::to('candidate-results');
});

Route::get('site', function() {
    return Redirect::to('candidate-results');
});

Route::get('login', 'HomeController@getIndex');

Route::group(array('prefix' => 'api/v1'), function() {
    Route::any('candidates', function () {
        return Candidate::all_data();
    });

    Route::any('parties', function () {
        return Party::all_data();
    });
});

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function() {

    Route::any('/',          'Admin\PostsController@index');
    Route::any('db_backup',  'Admin\PostsController@db_backup');
    Route::resource('posts', 'Admin\PostsController');
    Route::get('candidates', 'Admin\CandidatesController@getCandidates');
    Route::post('candidates/votes', 'Admin\CandidatesController@postAddVote');
});

Route::get('candidate-results', ['as'=>'candidate-results', 'uses'=>'HomeController@getCandidateResults']);

Route::get('results/search', ['as'=>'results.search', 'uses'=>'PostsController@getSearch']);
Route::get('updates/search', ['as'=>'updates.search', 'uses'=>'PostsController@getSearch']);
Route::get('news/search', ['as'=>'news.search', 'uses'=>'PostsController@getSearch']);
Route::get('voice-of-people/search', ['as'=>'voice-of-people.search', 'uses'=>'PostsController@getSearch']);

Route::resource('results', 'PostsController');
Route::resource('updates', 'PostsController');
Route::resource('news', 'PostsController');
Route::resource('voice-of-people', 'PostsController');
Route::get('login/fb', 'AuthController@getFBLogin');
Route::get('login/fb/callback', 'AuthController@getFBLoginCB');

Route::get('terms', 'PagesController@getTerms');
Route::get('help_us', 'PagesController@helpUs');
Route::get('know_us', 'PagesController@knowUs');
Route::get('hamro_neta', 'PagesController@hamroNeta');
Route::get('privacy', 'PagesController@getPrivacy');
Route::get('testimonials', ['as'=>'testimonials.index', 'uses'=>'PagesController@getTestimonials']);
Route::get('testimonials/{name}', ['as'=>'testimonials.show', 'uses'=>'PagesController@getTestimonial']);
Route::get('feedback', 'PagesController@getFeedback');
Route::post('feedback', 'PagesController@postFeedback');

Route::get('search', ['as'=>'search', 'uses'=>'HomeController@getSearch']);
Route::get('candidates/results', ['as'=>'candidates.results', 'uses'=>'CandidatesController@getResults']);

Route::get('users/activate/{id}/{code}', 'AuthController@getActivate');
Route::post('users/login', 'AuthController@postLogin');
Route::post('users/signup', 'AuthController@postSignup');
Route::get('users/logout', 'AuthController@getLogout');

Route::get('users/profile', ['before'=>'auth', 'uses'=>'UsersController@getProfile']);
Route::post('users/profile', ['before'=>'auth', 'uses'=>'UsersController@postProfile']);
Route::resource('users', 'UsersController');

Route::get('parties/all', 'PartiesController@getAll');
Route::resource('parties', 'PartiesController');

Route::get('candidates/graph', 'CandidatesController@getGraph');
Route::get('candidates/all', 'CandidatesController@getAll');
Route::get('candidates/vote', ['uses'=>'CandidatesController@getVote']);
Route::post('candidates/vote', ['before'=>'auth|csrf', 'uses'=>'CandidatesController@postVote']);
Route::get('candidates/{id}/edit', ['before'=>'auth.admin', 'uses'=>'CandidatesController@edit']);
Route::put('candidates/{id}', ['before'=>'auth.admin', 'uses'=>'CandidatesController@update']);
Route::resource('candidates', 'CandidatesController');

App::missing(function($exception) {
    return Response::view('errors.404', array(), 404);
});

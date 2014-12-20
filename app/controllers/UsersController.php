<?php

class UsersController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if (!Sentry::check()) {
            return Redirect::to('/')->withErrors('Please log in the website to continue');
        }
        if ($id == 'me') {
            $my_votes = UserVote::where('user_id', '=', Sentry::getUser()->id)
                                    ->orderBy('created_at', 'DESC')
                                    ->get();

            $user = User::where('users.id', '=', Sentry::getUser()->id)
                                ->join('profiles', 'users.id', '=', 'profiles.user_id')
                                ->first();

            if (Request::ajax()) {
                // If the request is AJAX, return only the list of parties without other html
                return View::make('site._partials.user-dashboard')
                            ->with('title', 'User Dashboard')
                            ->with('user', $user)
                            ->with('votes', $my_votes);

            } else {
                return View::make('site.users.dashboard')
                                ->with('title', 'User Dashboard')
                                ->with('user', $user)
                                ->with('votes', $my_votes);
            }
        }
    }

    public function getProfile()
    {
        $user_id = Sentry::getUser()->id;
        $profile = Profile::where('user_id', '=', $user_id)->first();

        if (empty($profile)) {
            $profile = new Profile();
            $profile->user_id = $user_id;
            $profile->save();
        }

        $user = User::where('users.id', '=', $user_id)
                            ->join('profiles', 'users.id', '=', 'profiles.user_id')
                            ->first();
        if (Request::ajax()) {
            // If the request is AJAX, return only the list of parties without other html
            return View::make('site._partials.profile')
                            ->with('user', $user)
                            ->with('title', 'User Profile');

        } else {
            return View::make('site.users.profile')
                            ->with('user', $user)
                            ->with('title', 'User Profile');
        }
    }

    public function postProfile()
    {
        $input = Input::all();
        $user_id = Sentry::getUser()->id;
        $input['email'] = 'something@yahoo.com'; // Random email to ensure unique email

        $change_pw = true;
        if (!isset($input['password'])) {
            $change_pw = false;
        } else {
            if ($input['password'] == '' && $input['password-re'] == '') {
                $change_pw = false;
            }
        }

        if (!$change_pw) {
            // Set random pw & pw-re for validation
            $input['password'] = 'asdfgh';
            $input['password-re'] = 'asdfgh';
        }

        $validation = User::validate($input);

        if ($validation->fails()) {

            return Redirect::back()->withInput()->withErrors($validation);
        }

        $user = Sentry::findUserById($user_id);

        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        if ($change_pw) {
            $user->password = $input['password'];
        }
        $user->save();

        $profile = Profile::where('user_id', '=', $user_id)->first();

        if (empty($profile)) {
            $profile = new Profile();
            $profile->user_id = $user_id;
        }
        if (Input::file('image')) {
            $profile->photo = $this->upload($input['image'], 'users', true);
        }
        $profile->username = $input['username'];
        $profile->save();

        Notification::success('Your profile has been updated');
        return Redirect::to('users/me');
    }

    protected function upload($file, $dir = null)
    {
        if ($file) {
            // Generate random dir
            if ( ! $dir) $dir = str_random(8);

            // Get file info and try to move
            $destination = Config::get('image.upload_path') . $dir;
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
}

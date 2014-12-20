<?php

class AuthController extends BaseController {

    public function postSignup()
    {
        $input = Input::all();
        $data = $input;

        $validation = User::validate($input);

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation);
        } else {
            $user = User::sign_up($input);
            $user = Sentry::getUser($user->id);
            $activationCode = $user->getActivationCode();
            $activation_url = URL::to("users/activate/$user->id/$activationCode");

            $data['activation_url'] = $activation_url;

            $message = 'Check the instructions on your email for details regarding activation of your account';

            Mail::send('emails.activation', $data, function($message) use ($data) {
                $message->from('no-reply@hamroneta.com', 'HamroNeta.com');

                $message->to($data['email'])->subject('Activate your user account');
            });

            return Redirect::to('candidate-results')
                            ->with('register_message', $message);
        }
    }

    /**
     * Activate an user
     * @param  int $id   User ID
     * @param  string $code Activation code
     * @return Redirect
     */
    public function getActivate($id, $code)
    {
        try {
            // Find the user using the user id
            $user = Sentry::findUserById($id);

            // Attempt to activate the user
            if ($user->attemptActivation($code)) {
                User::activate_user($user);

                Notification::success('Congratulations!!! Your account has been activated successfully.');
                return Redirect::to('users/profile');
            } else {
                // User activation failed
                return Redirect::to('/')
                                ->withErrors('Sorry! The user activation failed. ');
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            // User was not found
            return Redirect::to('/')
                            ->withErrors('Sorry! The user activation failed. ');
        } catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e) {
            return Redirect::to('/')
                            ->withErrors('Your user account is already activated.<br> You can log in the site with your credentials.');
        }
    }

    /**
     * Login action
     * @return Redirect
     */
    public function postLogin()
    {
        $credentials = array(
            'email'    => Input::get('email'),
            'password' => Input::get('password')
        );

        try {
            $user = Sentry::authenticate($credentials, false);

            $redir_url = Session::get('redir_url', 'site');
            Session::forget('redir_url');

            if ($user) {
                return Redirect::to($redir_url);
            }
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            return Redirect::to('/')
                                ->withErrors('Check your email for account activation details.');
        } catch(Exception $e) {
            return Redirect::to('/')
                        ->withErrors('Invalid username or password');
        }
    }

    /**
     * Logout action
     * @return Redirect
     */
    public function getLogout()
    {
        Sentry::logout();

        return Redirect::to('/');
    }

    public function getFBLogin()
    {
        if (Sentry::check()) {
            return Redirect::back();
        }
        $facebook = new Facebook(Config::get('facebook'));
        $params = array(
            'redirect_uri' => url('/login/fb/callback'),
            'scope' => 'email',
        );
        return Redirect::to($facebook->getLoginUrl($params));
    }

    public function getFBLoginCB()
    {
        if (Sentry::check()) {
            return Redirect::back();
        }
        $code = Input::get('code');
        if (strlen($code) == 0) return Redirect::to('/')->withErrors('There was an error communicating with Facebook');

        $facebook = new Facebook(Config::get('facebook'));
        $loginUrl = $facebook->getLoginUrl(Config::get('facebook'));
        $uid = $facebook->getUser();

        if ($uid == 0) return Redirect::to($loginUrl);

        try {
            // Proceed knowing you have a logged in user who's authenticated.
            $me = $facebook->api('/me');
        } catch (FacebookApiException $e) {
            Log::error($e);
            return Redirect::to('/')->withErrors($e->getMessage());
        } catch(Exception $e) {
            Log::error($e);
            return Redirect::to('/')->withErrors($e->getMessage());
        }
        // dd($me);
        if (!isset($me['email'])) {
            $me['email'] = $me['username'] . '@facebook.com';
        }
        // var_dump($uid);
        // dd($facebook->api('/me'));
        $existing_email = User::where('email', '=', $me['email'])
                                    ->first();

        $profile = Profile::whereUid($uid)->first();

        if ($existing_email && empty($profile)) {
            return Redirect::to('/')
                            ->withErrors('An account is already registered with ' . $me['email']);
        }

        if (empty($profile)) {

            $user = Sentry::register(array(
                            'email'      => $me['email'],
                            'password'   => 'HsAEQQC#3oB32B3',
                            'first_name' => $me['first_name'],
                            'last_name'  => $me['last_name']
                        ), true);

            $profile = new Profile();
            $profile->uid = $uid;
            $profile->username = $me['username'];
            $profile->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
            $profile->user_id = $user->id;

            $userGroup = Sentry::findGroupById(1);

            // Assign the group to the user
            $user->addGroup($userGroup);
        } else {
            $user = Sentry::findUserById($existing_email->id);
        }

        $profile->access_token = $facebook->getAccessToken();
        $profile->save();

        Sentry::login($user, false);
        Notification::success('Congratulations!!! You have been logged in with Facebook.');

        return Redirect::to('site');
    }
}

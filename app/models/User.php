<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel {

    protected $table = 'users';
    protected $hidden = array('password');

    public static $rules = array(
        'email'       => 'required|email|unique:users,email',
        'password'    => 'required|min:6',
        'password-re' => 'required|same:password',
    );

    public static $messages = array(
        'password.required'    => 'The password cannot be empty.',
        'password-re.same'     => 'Both the passwords must be same.',
        'password-re.required' => 'Both the password fields must be filled.',
    );

    public function profiles()
    {
        return $this->hasMany('Profile');
    }

    public static function sign_up($input)
    {
        try {
            // Create the user
            $user = Sentry::register(array(
                'email'    => $input['email'],
                'password' => $input['password'],
            ));

            return $user;

        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            echo 'Login field is required.';
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            echo 'Password field is required.';
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            echo 'User with this login already exists.';
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            echo 'Group was not found.';
        }
    }

    public static function activate_user($user)
    {
        // Find the group using the group id
        $userGroup = Sentry::findGroupById(1);

        // Assign the group to the user
        $user->addGroup($userGroup);

        Sentry::login($user, false);

        $profile = new Profile;
        $profile->user_id = $user->id;
        $profile->save();
    }

    public static function is_admin()
    {
        if (!Sentry::check()) {
            return false;
        } else {
            $user = Sentry::getUser();
            $admin = Sentry::findGroupByName('Administrators');
            if (!$user->inGroup($admin)) {
                return false;
            }
            return true;
        }
    }
}

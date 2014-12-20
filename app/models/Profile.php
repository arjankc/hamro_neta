<?php

class Profile extends Eloquent {

    public function user()
    {
        return $this->belongsTo('User');
    }

    public static function photo()
    {
        $user = Sentry::getUser();
        $profile = Profile::where('user_id', '=', $user->id)->first();

        if (empty($profile) || !isset($profile->photo) || $profile->photo=='') {
            return 'img/dummy.jpg';
        }

        return $profile->photo;
    }

    public static function username()
    {
        $user = Sentry::getUser();
        $profile = Profile::where('user_id', '=', $user->id)->first();

        if (empty($profile) || $profile->username=='') {
            return Str::limit(Sentry::getUser()->email, 18);
            $result = explode('@', Sentry::getUser()->email);
            return $result[0];
        }
        return ($profile) ? $profile->username : '';
    }
}

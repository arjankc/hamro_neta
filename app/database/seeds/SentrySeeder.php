<?php

class SentrySeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        DB::table('groups')->delete();
        DB::table('users_groups')->delete();

        $user = Sentry::createUser(array(
            'email'       => 'xx@xx.com',
            'password'    => 'xx',
            'first_name'  => 'xx',
            'last_name'   => 'xx',
            'activated'   => 1,
        ));

        $group = Sentry::createGroup(array(
            'name'        => 'Users',
            'permissions' => array(
                'admin' => 1,
                'users' => 1,
            ),
        ));

        // Assign user permissions
        $userGroup = Sentry::findGroupById(1);
        $user->addGroup($userGroup);
    }

}

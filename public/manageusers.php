<?php
	require_once 'init.php';
    
    $user = new User; // WITHOUT parameter (see constructor)!
    
    if ($user->isLoggedIn() && $user->hasPermissions('moderator')) {

        $users = Database::getInstance()->findAll('users')->results(); // returns array of stdClass Objects
        $groups  = Database::getInstance()->findAll('groups'); // returns Database Object

        foreach ($users as $user1) {
            // find the corresponding group by `groupid` from `users table`
            $group = $groups->findByCriteria('groups', ['id', '=', $user1->groupid])->first();

            // writing the the user data with the information from both tables into the `$users` array
            $records[] = (object)[
                'id'        => $user1->id,
                'username'  => $user1->username,
                'email'     => $user1->email,
                'groupid'     => $user1->groupid,
                'groupname'      => $group->name
            ];
        }

        $title = 'Users\' managment';
        
        include __DIR__ . '/../templates/nav.html.php';
        
        $output = __DIR__ . '/../templates/manageusers.html.php';

        include __DIR__ . '/../templates/layout.html.php';
    } else {
        Redirect::to(404);
    }

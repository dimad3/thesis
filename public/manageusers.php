<?php
	require_once 'init.php';
    
    $user = new User; // WITHOUT parameter (see constructor)!
    
    if ($user->isLoggedIn() && $user->hasPermissions('admin')) {

        $records = Database::getInstance()->findAll('users')->results(); // returns array

        $title = 'Users\' managment';
        
        include __DIR__ . '/../templates/nav.html.php';
        
        $output = __DIR__ . '/../templates/manageusers.html.php';

        include __DIR__ . '/../templates/layout.html.php';
    } else {
        Redirect::to(404);
    }

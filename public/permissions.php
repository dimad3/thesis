<?php
require_once 'init.php';
$user = new User;

if ($user->isLoggedIn() && $user->hasPermissions('admin')) {
    
    $groupid = Database::getInstance()->findByCriteria('users', ['id', '=', $_GET['id']])->first()->groupid;
    
    if ($groupid == 1) {
        Database::getInstance()->update('users', $_GET['id'], ['groupid' => 3]);
    }
    elseif ($groupid == 3) {
        Database::getInstance()->update('users', $_GET['id'], ['groupid' => 1]);
    }

    Redirect::to('manageusers.php');
} else {
    Redirect::to(404);
}
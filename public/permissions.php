<?php
require_once __DIR__ . '/../includes/init.php';

$user = new User;

if ($user->isLoggedIn() && $user->hasPermissions('admin')) {
    
    $groupid = DatabaseTable::getInstance()->findByCriteria('users', ['id', '=', $_GET['id']])->first()->groupid;
    
    if ($groupid == 1) {
        DatabaseTable::getInstance()->update('users', $_GET['id'], ['groupid' => 3]);
    }
    elseif ($groupid == 3) {
        DatabaseTable::getInstance()->update('users', $_GET['id'], ['groupid' => 1]);
    }

    Redirect::to('manageusers.php');
} else {
    Redirect::to(404);
}
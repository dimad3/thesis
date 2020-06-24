<?php
require_once 'init.php';
$user = new User;
if ($user->isLoggedIn() && $user->hasPermissions('moderator')) {
    
    Database::getInstance()->delete('users', ['id', '=', $_GET['id']]);

    Redirect::to('manageusers.php');
} else {
    Redirect::to(404);
}
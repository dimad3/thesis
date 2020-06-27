<?php
require_once __DIR__ . '/../includes/init.php';

$user = new User;

if ($user->isLoggedIn() && $user->hasPermissions('moderator')) {
    
    DatabaseTable::getInstance()->delete('users', ['id', '=', $_GET['id']]);

    Redirect::to('manageusers.php');
} else {
    Redirect::to(404);
}
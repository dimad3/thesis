<?php
require_once 'init.php';
$user = new User;
if ($user->isLoggedIn() && $user->hasPermissions('admin')) {    // $db = new Database->getInstance();
    
    //$db->delete('users', $GET['id']);
    Database::getInstance()->delete('users', ['id', '=', $_GET['id']]);

    Redirect::to('index.php');
} else {
    Redirect::to(404);
}
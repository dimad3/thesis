<?php
require_once 'init.php';

$user = new User;

if ($user->isLoggedIn()) {
    $user->logout();

    Redirect::to('index.php');
} else {
    Redirect::to(404);
}
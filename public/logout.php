<?php
require_once __DIR__ . '/../includes/init.php';

$user = new User;

if ($user->isLoggedIn()) {
    $user->logout();

    Redirect::to('index.php');
} else {
    Redirect::to(404);
}
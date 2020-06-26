<?php
require_once __DIR__ . '/../includes/init.php';

$records = Database::getInstance()->findAll('users')->results(); // returns array

$title = 'Home';

include_once __DIR__ . '/../templates/nav.html.php';

$output = __DIR__ . '/../templates/home.html.php';

include_once __DIR__ . '/../templates/layout.html.php';
//C:\laragon\www\thesis\includes\init.php
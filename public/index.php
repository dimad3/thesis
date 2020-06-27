<?php
require_once __DIR__ . '/../includes/init.php';

$records = DatabaseTable::getInstance()->findAll('users')->results(); // returns array

$title = 'Home';

include_once __DIR__ . '/../templates/nav.html.php';

$output = __DIR__ . '/../templates/home.html.php';

include_once __DIR__ . '/../templates/layout.html.php';

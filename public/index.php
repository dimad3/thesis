<?php
	require_once 'init.php';

	$records = Database::getInstance()->findAll('users')->results(); // returns array

	$title = 'Home';
	
	include __DIR__ . '/../templates/nav.html.php';
	
	$output = __DIR__ . '/../templates/home.html.php';

	include __DIR__ . '/../templates/layout.html.php';

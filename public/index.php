<?php
	require_once 'init.php';

	$records1 = Database::getInstance()->findAll('users'); // returns Database Object
	$records = (array)$records1->results();

	$title = 'Home';

	$output = __DIR__ . '/../templates/home.html.php';

	include __DIR__ . '/../templates/layout.html.php';

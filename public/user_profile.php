<?php
	require_once 'init.php';

	if(isset ($_GET['id'])) {
		/* The `id` of an user must be supplied using a GET variable —
		so that visiting `user_profile.php?id=3`, for example, will execute the query
		`SELECT * FROM users WHERE id=3` and store the resulting record in the `$record1` object */
		$record1 = Database::getInstance()->findByCriteria('users', ['id', '=', $_GET['id']])->first(); // returns stdClass Object
	};
	
	$title = 'User profile';

	include __DIR__ . '/../templates/nav.html.php';

	$output = __DIR__ . '/../templates/user_profile.html.php';

	include __DIR__ . '/../templates/layout.html.php';

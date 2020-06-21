<?php
	require_once 'init.php';

	if(isset ($_GET['id'])) {
		/* The `id` of an user must be supplied using a GET variable —
		so that visiting `editjoke.php?id=4`, for example, will execute the query
		`SELECT * FROM joke WHERE id=4` and store the resulting record in the `$record1` object */
		// $record1 = $jokesTable->findById($_GET['id']); // p.325
		// $criteriaVal = 3;
		
		$record1 = Database::getInstance()->findByCriteria('users', ['id', '=', $_GET['id']]); // returns Database Object
		$record = (array)$record1->results()[0];
	};
	
	$title = 'User profile';

	include __DIR__ . '/../templates/nav.html.php';

	$output = __DIR__ . '/../templates/user_profile.html.php';

	include __DIR__ . '/../templates/layout.html.php';

<?php
require_once __DIR__ . '/../includes/init.php';

if(isset ($_GET['id'])) {
	/* The `id` of an user must be supplied using a GET variable —
	so that visiting `userprofile.php?id=3`, for example, will execute the query
	`SELECT * FROM users WHERE id=3` and store the resulting record in the `$record1` object */
	$record = Database::getInstance()->findByCriteria('users', ['id', '=', $_GET['id']])->first(); // returns stdClass Object

	$title = 'User profile';

	include_once __DIR__ . '/../templates/nav.html.php';

	$output = __DIR__ . '/../templates/userprofile.html.php';

	include_once __DIR__ . '/../templates/layout.html.php';

} else {
    Redirect::to(404);
}

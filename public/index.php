<?php
	require_once 'init.php';

	$users = Database::getInstance()->findAll('users'); // returns Database Object

	$title = 'Home';

	$output = __DIR__ . '/../templates/home.html.php';

	include __DIR__ . '/../templates/layout.html.php';

?>


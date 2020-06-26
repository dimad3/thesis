<?php
require_once 'init.php';

// L#8
// Input::isSubmited() - check whether the form was submited (see forum)
// Returns TRUE if it was and FALSE if it was NOT
$form_submited = Input::isSubmited();
if ($form_submited == true) { // true or false
	
	$rulesaccepted = (Input::get('rulesaccepted')) === 'on' ? true : false; // returns BOOLEAN
	if ($rulesaccepted == true) { // true or false

		// L#9 05:10 - get a VALUE of a form's field after the form was submited
		// 'token' - the name of the form's field from which to get the VALUE
		$fieldValue = Input::get('token');  // true or false

		// check whether `form's token value` exists in the `$_SESSION[] array`
		$tokenExists = Token::check($fieldValue); // true or false
		
		if ($tokenExists == true) { // L#9 
	
			$validation = new Validate();

			$validation = $validation->check($_POST,
				[
					'username' => [                 // field name
						'required'  => true,
						'min'       => 3,
						'max'       => 12,
						'unique'    => 'users'      // the name of the table
					],
					
					'email' =>  [                   // 'email'field name
						'required'  =>  true,
						'email'     =>  true,       // 'email' rule name
						'unique'    =>  'users'     // the name of the table where to check the email
					],

					'password' => [                 // field name
						'required'  => true,
						'min'       => 3
					],

					'password_again' => [           // field name
						'required'  => true,
						'min'       => 3,
						'matches'   => 'password'   // the name of the field to compare with
					]
				]
			);
			// Returns `Validate object`
		}

		// check whether `$passed property` of `Validate object` is TRUE
		if ($validation->passed()) {
			
			$user = new User;
			
			// insert datta in db
			$user = $user->add([
				// set fields and its values to be inserted in db
				'username' => Input::get('username'),
				'email' =>    Input::get('email'),
				/*
				password    Required. The user's password (string)
				algo        Required. A password algorithm constant denoting the algorithm 
							to use when hashing the password.
				options     Optional. An associative array containing options.
							See the password algorithm constants for documentation on 
							the supported options for each algorithm. 
				Returns the hashed password (as string), or FALSE on failure */
				'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT)
			]);
			
			// unset($_POST); // delete $_POST from Superglobals
			$_POST = array();
			Session::flash('register_ok', 'Вы успешно зарегестрировались на нашем портале!');
			
			Redirect::to('index.php');
		}
	} else {
		Session::flash('acceptrules_off',
		'Для того чтобы завершить регистрацию Вам надо дать своё согласие соблюдать правила нашего портала');
	}
}

$custom_css = 'style1.css';  // ok
// $css = 'css/style.css'; // ok
// $css = __DIR__ . '/../css/style.css';  // BUG ???
$title = 'User Register';

$output = __DIR__ . '/../templates/register.html.php';

include __DIR__ . '/../templates/layout.html.php';

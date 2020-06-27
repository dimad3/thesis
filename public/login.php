<?php
require_once __DIR__ . '/../includes/init.php';

$user = new User;

if (!$user->isLoggedIn()) {
    // L#8
    // Input::isSubmited() - check whether the form was submited (see forum)
    // Returns TRUE if it was and FALSE if it was NOT
    $form_submited = Input::isSubmited();
    if ($form_submited == true) { // true or false
        // check
        if(Token::check(Input::getFieldVal('token'))) {

            $validation = new Validation();

            // check fields values to meet required parameters
            $validation = $validation->check($_POST, [
                'email' => [
                    'required'=>true,
                    'email'=>true],
                'password'  =>  ['required'=>true]
            ]);
            // Returns `Validate object`

            // check whether the `$passed property` of `Validate object` is TRUE or FALSE
            if($validation->passed()) {   // Returns TRUE or FALSE
                $user = new User; // without parameter
                
                // check whether `remember checkbox` is set
                $remember = (Input::getFieldVal('remember')) === 'on' ? true : false; // returns BOOLEAN

                // call `login method` on `User Object`
                $loggedIn = $user->login(Input::getFieldVal('email'), Input::getFieldVal('password'), $remember); // returns boolean

                if($loggedIn) {    // = if(isset($login)) {
                    Redirect::to('index.php');
                } else {
                    Session::flash('login_failed', 'Логин или пароль неверны');
                }
            }
        }
    }

    $custom_css = 'style.css';

    $title = 'Log in';

    $output = __DIR__ . '/../templates/login.html.php';

    include_once __DIR__ . '/../templates/layout.html.php';

} else {
    Redirect::to(404);
}
